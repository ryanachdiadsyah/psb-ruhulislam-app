<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OtpService;
use Illuminate\Support\Facades\Auth;
use App\Services\Whatsapp\WhatsappGateway;

class PhoneVerificationController extends Controller
{
    public function verify(Request $request, OtpService $otp)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $user = $request->user();

        if (! $otp->verifyForUser($user->id, $request->otp)) {
            return back()->withErrors([
                'otp' => 'Invalid or expired OTP',
            ]);
        }

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function resend(Request $request, OtpService $otp, WhatsappGateway $wa)
    {
        $user = $request->user();

        // rate limit (yang sudah ada)

        $code = $otp->generateForUser($user->id);

        $wa->send(
            $user->phone_number,
            "Kode verifikasi Anda: {$code}"
        );

        return back()->with('status', 'OTP sent');
    }
}
