<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsurePhoneIsVerified;
use App\Http\Controllers\Auth\PhoneVerificationController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::view('/', 'landing.home')->name('welcome');


Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::view('/register', 'auth.register')->name('register');
    
    Route::view('/forgot-password', 'auth.forgot-password')
        ->name('password.request');
    
    Route::post('/forgot-password/request', [ResetPasswordController::class, 'requestOtp'])
        ->middleware(['throttle:verify-phone.request'])
        ->name('password.otp.request');
    
    Route::view('/reset-password', 'auth.reset-password')
        ->name('password.reset');
    
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
        ->middleware(['throttle:10,1'])
        ->name('password.otp.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', function () {
        auth()->logout();
        return redirect()->route('login');
    })->name('logout');


    Route::view('/verify-phone', 'auth.verify-phone')        
        ->name('phone.verify.notice');
    
    Route::post('/verify-phone', [PhoneVerificationController::class, 'verify'])
        ->middleware([
            'throttle:10,1', // max 10 attempt / menit
        ])
        ->name('phone.verify');
    
    Route::post('/verify-phone/request', [PhoneVerificationController::class, 'requestOtp'])
        ->middleware([
            'throttle:verify-phone.request',
        ])
        ->name('phone.verify.request');

    Route::view('/dashboard', 'app.dashboard')
        ->middleware([EnsurePhoneIsVerified::class])
        ->name('dashboard');
});
