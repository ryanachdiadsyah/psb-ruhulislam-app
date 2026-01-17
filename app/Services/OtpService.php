<?php

namespace App\Services;

use App\Models\OtpVerification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class OtpService
{
    public function generateForUser(int $userId): string
    {
        // Hapus OTP lama
        OtpVerification::where('user_id', $userId)->delete();

        $otp = random_int(100000, 999999);

        OtpVerification::create([
            'user_id'    => $userId,
            'code'       => Hash::make($otp),
            'expires_at' => Carbon::now()->addMinutes(5),
            'attempts'   => 0,
        ]);

        return (string) $otp;
    }
}
