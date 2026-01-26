<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class InvoiceService
{
    public function __construct()
    {
        //
    }

    public function createRegistrationInvoice(User $user): void
    {
        $onboarding = $user->onboarding;

        // Guard keras
        if (! $onboarding || ! $onboarding->completed_at) {
            return;
        }

        // Hanya REGULAR (punya kewajiban bayar)
        if ($onboarding->payment_status !== 'UNPAID') {
            return;
        }

        // Jangan buat dua kali
        $exists = Invoice::where('user_id', $user->id)
            ->where('title', 'Biaya Pendaftaran')
            ->exists();

        if ($exists) {
            return;
        }

        DB::transaction(function () use ($user, $onboarding) {

            $invoice = Invoice::create([
                'user_id'      => $user->id,
                'code'         => 'INV-' . now()->format('Y') . '-' . strtoupper(Str::random(6)),
                'title'        => 'Biaya Pendaftaran',
                'total_amount' => $onboarding->fee_amount,
                'due_date'     => now()->addDays(3),
                'status'       => 'UNPAID',
            ]);

            InvoiceItem::create([
                'invoice_id'     => $invoice->id,
                'label'          => 'Pendaftaran Jalur Reguler',
                'amount'         => $onboarding->fee_amount,
                'due_date'       => $invoice->due_date,
                'status'         => 'UNPAID',
                'payment_method' => null, // dipilih di invoice page
                'payment_channel'=> null,
            ]);
        });
    }
}
