<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsurePhoneIsVerified;
use App\Http\Controllers\Auth\PhoneVerificationController;

Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');
Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');


Route::view('/dashboard', 'app.dashboard')
    ->middleware(['auth', EnsurePhoneIsVerified::class])
    ->name('dashboard');

Route::view('/verify-phone', 'auth.verify-phone')
    ->middleware('auth')
    ->name('phone.verify.notice');

Route::post('/verify-phone', [PhoneVerificationController::class, 'verify'])
    ->middleware('auth')
    ->name('phone.verify');

Route::post('/verify-phone/resend', [PhoneVerificationController::class, 'resend'])
    ->middleware('auth')
    ->name('phone.verify.resend');