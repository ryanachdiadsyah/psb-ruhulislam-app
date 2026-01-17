<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OtpService;
use Illuminate\Support\Facades\Auth;

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
}
