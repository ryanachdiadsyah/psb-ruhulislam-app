<?php

namespace App\Services;

use App\Models\OtpVerification;
use App\Models\User;
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

    public function verifyForUser(int $userId, string $inputOtp): bool
    {
        $record = OtpVerification::where('user_id', $userId)->first();

        if (! $record) {
            return false;
        }

        // Expired
        if (Carbon::now()->greaterThan($record->expires_at)) {
            $record->delete();
            return false;
        }

        // Max attempts
        if ($record->attempts >= 5) {
            $record->delete();
            return false;
        }

        // Check OTP
        if (! Hash::check($inputOtp, $record->code)) {
            $record->increment('attempts');
            return false;
        }

        // SUCCESS
        User::where('id', $userId)->update([
            'phone_verified_at' => Carbon::now(),
        ]);

        $record->delete();

        return true;
    }
}
