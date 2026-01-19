<?php

namespace App\Services;

use App\Models\OtpVerification;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class OtpService
{
    public const PURPOSE_VERIFY_PHONE = 'verify_phone';
    public const PURPOSE_RESET_PASSWORD = 'reset_password';
    public const REUSE = 'REUSE';
    
    public function generateForUser(int $userId, string $channel, string $purpose = self::PURPOSE_VERIFY_PHONE): string
    {
        $active = OtpVerification::where('user_id', $userId)
            ->where('purpose', $purpose)
            ->latest('created_at')
            ->first();

        if ($active) {
            if (now()->lessThan($active->expires_at) && $active->attempts < 5) {
                if ($active->channel !== $channel) {
                    throw new \RuntimeException('OTP already sent via different channel');
                }
                return self::REUSE;
            }
            $active->delete();
        }

        $otp = null;

        DB::transaction(function () use ($userId, $channel, $purpose, &$otp) {
            $otp = random_int(100000, 999999);

            OtpVerification::create([
                'user_id'    => $userId,
                'channel'    => $channel,
                'purpose'    => $purpose,
                'code'       => \Hash::make($otp),
                'expires_at' => now()->addMinutes(5),
                'attempts'   => 0,
            ]);
        });

        return (string) $otp;
    }

    public function verifyForUser(int $userId, string $inputOtp, string $purpose = self::PURPOSE_VERIFY_PHONE): bool
    {
        $record = OtpVerification::where('user_id', $userId)
            ->where('purpose', $purpose)
            ->latest('created_at')
            ->first();

        if (! $record) return false;

        if (now()->greaterThan($record->expires_at) || $record->attempts >= 5) {
            $record->delete();
            return false;
        }

        if (! \Hash::check($inputOtp, $record->code)) {
            $record->increment('attempts');
            return false;
        }

        // SUCCESS — tindakan tergantung purpose
        if ($purpose === self::PURPOSE_VERIFY_PHONE) {
            User::where('id', $userId)->update([
                'phone_verified_at' => now(),
                'verified_channel' => $record->channel,
            ]);
        }

        $record->delete();
        return true;
    }
}
