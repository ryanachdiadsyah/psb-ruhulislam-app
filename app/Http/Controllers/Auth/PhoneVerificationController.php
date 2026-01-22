<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OtpService;
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

        return redirect()->route('dashboard')->with([
            'status' => 'success',
            'message' => 'Phone number verified successfully.',
        ]);
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

        // Delete Soon if sms method is implemented on server side
        if ($data['channel'] === 'sms') {
            return back()->with([
                'status' => 'error',
                'message' => 'Pengiriman OTP melalui SMS belum tersedia saat ini. Silahkan pilih WhatsApp sebagai channel verifikasi.',
            ]);
        }

        try {
            $code = $otp->generateForUser($user->id, $data['channel']);
        } catch (\RuntimeException $e) {
            return back()->with([
                'status'    => 'error',
                'message'   => 'OTP sudah dikirim melalui channel lain. Silakan tunggu sampai OTP kadaluarsa.',
            ]);
        }

        // Kalau OTP lama masih aktif → jangan kirim ulang
        if ($code === 'REUSE') {
            return back()->with([
                'status' => 'info',
                'message' => 'OTP sudah dikirim sebelumnya.',
                'otp_sent' => true,
                'otp_sent_at' => now()->timestamp,
            ]);
        }

        // Kirim OTP sesuai channel
        if ($data['channel'] === 'whatsapp') {
            dispatch(new SendOtpWhatsapp(
                $user->phone_number,
                "Assalamualaikum,\n\nKode OTP Anda adalah: *{$code}*\n\n_Jangan berikan kode ini kepada siapapun._ Terima kasih.",
            ));
        }

        // Enable back after sms method is implemented on server side
        // if ($data['channel'] === 'sms') {
        //     return back()->with([
        //         'status' => 'error',
        //         'message' => 'Pengiriman OTP melalui SMS belum tersedia saat ini. Silahkan pilih WhatsApp sebagai channel verifikasi.',
        //     ]);
        // }

        return back()->with([
            'status' => 'success',
            'message' => 'Kode OTP telah dikirim, silahkan cek pesan '.$data['channel'].' Anda.',
            'otp_sent' => true,
            'otp_sent_at' => now()->timestamp,
        ]);
    }
}
