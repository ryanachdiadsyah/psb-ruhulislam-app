<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManualPaymentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

    public function manualPaymentUpload(Request $request)
    {
        
    }
}
