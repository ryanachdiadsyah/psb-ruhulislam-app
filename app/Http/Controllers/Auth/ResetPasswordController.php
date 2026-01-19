<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendOtpWhatsapp;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function requestOtp(Request $request, OtpService $otp)
    {
        $request->validate([
            'phone_number' => ['required', 'string', 'regex:/^08[0-9]{8,11}$/'],
        ], [
            'phone_number.required' => 'Nomor telepon wajib diisi.',
            'phone_number.regex' => 'Format nomor telepon tidak valid. Gunakan format tanpa kode negara, misal: 081234567890.'
        ]);

        $user = User::where('phone_number', $request->phone_number)->first();
        $channel = $user->verified_channel ?? 'whatsapp';
        
        if (! $user) {
            return back()->with([
                'status' => 'info',
                'message' => 'Jika nomor terdaftar, OTP akan dikirim.',
            ]);
        }

        try {
            $code = $otp->generateForUser(
                $user->id,
                $channel,
                OtpService::PURPOSE_RESET_PASSWORD
            );
        } catch (\RuntimeException $e) {
            return back()->with([
                'status' => 'info',
                'message' => 'OTP sudah dikirim. Silakan tunggu.',
            ]);
        }

        if ($code === OtpService::REUSE) {
            return back()->with([
                'status' => 'info',
                'message' => 'OTP sudah dikirim. Silakan cek pesan Anda.',
            ]);
        }

        if ($channel === 'whatsapp') {
            dispatch(new SendOtpWhatsapp(
                $user->phone_number,
                "Kode OTP reset password Anda: *{$code}*\n\nJangan bagikan kode ini."
            ));
        }

        return redirect()->route('password.reset')->with([
            'status' => 'success',
            'message' => 'Jika nomor terdaftar, OTP akan dikirim.',
            'otp_sent' => true,
            'phone_number' => $request->phone_number,
        ]);
    }

    public function reset(Request $request, OtpService $otp)
    {
        $request->validate([
            'phone_number' => ['required', 'string', 'regex:/^08[0-9]{8,11}$/'],
            'otp' => ['required', 'digits:6'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::where('phone_number', $request->phone_number)->first();

        // Pesan netral (anti user enumeration)
        if (! $user) {
            return back()->withErrors([
                'otp' => 'Invalid OTP or expired.',
            ]);
        }

        $ok = $otp->verifyForUser(
            $user->id,
            $request->otp,
            OtpService::PURPOSE_RESET_PASSWORD
        );

        if (! $ok) {
            return back()->withErrors([
                'otp' => 'Invalid OTP or expired.',
            ]);
        }

        // Set password baru
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with([
            'status' => 'success',
            'message' => 'Password updated successfully. Please login.',
        ]);
    }
}
