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

        return redirect()->route('dashboard');
    }

    public function requestOtp(Request $request, OtpService $otp)
    {
        $user = $request->user();

        if ($user->phone_verified_at) {
            return redirect()->route('dashboard');
        }

        $data = $request->validate([
            'channel' => ['required', 'in:whatsapp,sms'],
        ]);

        try {
            $code = $otp->generateForUser($user->id, $data['channel']);
        } catch (\RuntimeException $e) {
            return back()->with([
                'status'    => 'danger',
                'message'   => 'OTP sudah dikirim melalui channel lain. Silakan tunggu sampai OTP kadaluarsa.',
            ]);
        }

        // Kalau OTP lama masih aktif → jangan kirim ulang
        if ($code === 'REUSE') {
            return back()->with([
                'status'    => 'info',
                'message'   => 'OTP sudah dikirim melalui channel lain. Silakan tunggu sampai OTP kadaluarsa.',
            ]);
        }

        // Kirim OTP sesuai channel
        if ($data['channel'] === 'whatsapp') {
            dispatch(new SendOtpWhatsapp(
                $user->phone_number,
                "Assalamualaikum,\n\nKode OTP Anda adalah: *{$code}*\n\nJangan berikan kode ini kepada siapapun."
            ));
        }

        // SMS menyusul nanti
        return back()->with([
            'status'    => 'success',
            'message'   => 'Kode OTP telah dikirim ke nomor telepon Anda melalui ' . strtoupper($data['channel']) . '.',
        ]);
    }
}
