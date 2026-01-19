<?php

namespace App\Services;

use App\Models\OtpVerification;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class OtpService
{
    public function generateForUser(int $userId, string $channel): string
    {
        // Cek OTP aktif
        $active = OtpVerification::where('user_id', $userId)->first();

        if ($active) {
            // Jika masih valid & attempts belum habis, KUNCI channel
            if (now()->lessThan($active->expires_at) && $active->attempts < 5) {
                if ($active->channel !== $channel) {
                    throw new \RuntimeException('OTP already sent via different channel');
                }

                // Reuse OTP lama (tidak regenerate)
                return 'REUSE'; // controller yang memutuskan kirim ulang atau tidak
            }

            // OTP expired / attempts habis → reset
            $active->delete();
        }

        $otp = random_int(100000, 999999);

        OtpVerification::create([
            'user_id'    => $userId,
            'channel'    => $channel,
            'code'       => \Hash::make($otp),
            'expires_at' => now()->addMinutes(5),
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
