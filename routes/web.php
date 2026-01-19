<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsurePhoneIsVerified;
use App\Http\Controllers\Auth\PhoneVerificationController;

Route::get('/', function () {
    return App::environment('production') ? view('welcome') : redirect()->route('dashboard');
})->name('home');


Route::view('/dashboard', 'app.dashboard')
    ->middleware(['auth', EnsurePhoneIsVerified::class])
    ->name('dashboard');

Route::view('/verify-phone', 'auth.verify-phone')
    ->middleware('auth')
    ->name('phone.verify.notice');

Route::post('/verify-phone', [PhoneVerificationController::class, 'verify'])
    ->middleware([
        'auth',
        'throttle:10,1', // max 10 attempt / menit
    ])
    ->name('phone.verify');

Route::post('/verify-phone/request', [PhoneVerificationController::class, 'requestOtp'])
    ->middleware([
        'auth',
        'throttle:verify-phone.request',
    ])
    ->name('phone.verify.request');