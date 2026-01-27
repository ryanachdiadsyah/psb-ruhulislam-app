<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManualPaymentUploadRequest;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Storage;

class PaymentController extends Controller
{
    public function initiate(Request $request)
    {
        $user = $request->user();
        $onboarding = $user->onboarding;

        // Guard 1: onboarding harus complete
        if (! $onboarding || ! $onboarding->completed_at) {
            abort(403, 'Onboarding not completed');
        }

        // Guard 2: jalur gratis tidak boleh initiate
        if ($onboarding->payment_status === 'EXEMPT') {
            abort(403, 'Payment not required');
        }

        // Guard 3: hanya UNPAID yang boleh initiate
        if ($onboarding->payment_status !== 'UNPAID') {
            abort(403, 'Invalid payment state');
        }

        // Generate reference sekali saja
        if (! $onboarding->payment_reference) {
            $onboarding->update([
                'payment_reference' => 'PSB-' . strtoupper(Str::random(10)),
            ]);
        }

        return response()->json([
            'reference' => $onboarding->payment_reference,
            'amount'    => $onboarding->fee_amount,
            'currency'  => 'IDR',
        ]);
    }

    public function manualPaymentUpload(ManualPaymentUploadRequest $request)
    {
        $user = auth()->user();

        $itemIds = $request->selected_items;

        $items = InvoiceItem::whereIn('id', $itemIds)
            ->where('status', 'UNPAID')
            ->whereHas('invoice', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->get();

        if ($items->count() !== count($itemIds)) {
            return back()->withErrors([
                'selected_items' => 'Beberapa item tidak valid atau sudah dibayar.',
            ])->withInput();
        }

        $file     = $request->file("payment_proof");
        $folder   = "student/" . auth()->id() . "/psb_payments";
        $filename = "payment_proof_" . time() . "_." . $file->getClientOriginalExtension();
        $fullPath = $folder . '/' . $filename;

        Storage::disk('s3')->put($fullPath, file_get_contents($file));

        foreach ($items as $item) {
            $item->update([
                'payment_method' => 'MANUAL',
                'payment_channel' => $request->payment_channel,
                'payment_proof' => $fullPath,
                'status' => 'WAITING_CONFIRMATION',
            ]);
        }

        return back()->with([
            'status'    => 'success',
            'message'   => 'Bukti pembayaran berhasil diunggah. Silakan tunggu konfirmasi dari admin.',
        ]);
    }
}
