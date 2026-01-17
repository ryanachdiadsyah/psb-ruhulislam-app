<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OtpService;
use Illuminate\Support\Facades\Auth;
use App\Services\Whatsapp\WhatsappGateway;
use App\Jobs\SendOtpWhatsapp;

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
        $code = $otp->generateForUser($user->id);
        dispatch(new SendOtpWhatsapp(
            $user->phone_number,
            "Assalamualaikum, Terima Kasih sudah mendaftarkan nomor Anda pada aplikasi Penerimaan Santri Baru.\n\nKode OTP anda adalah : *{$code}*\n\n_Jangan berikan kode ini kepada siapapun._\n_Ruhul Islam Anak Bangsa_"
        ));
        return back()->with('status', 'OTP sent');
    }
}
