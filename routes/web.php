<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsurePhoneIsVerified;
use App\Http\Controllers\Auth\PhoneVerificationController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WizardController;

Route::view('/', 'landing.home')->name('welcome');

// Only for guests (unauthenticated users)
Route::middleware('guest')->group(function () {
    Route::view('login', 'auth.login')->name('login');
    Route::view('register', 'auth.register')->name('register');
    
    Route::view('forgot-password', 'auth.forgot-password')
        ->name('password.request');
    
    Route::post('forgot-password/request', [ResetPasswordController::class, 'requestOtp'])
        ->middleware(['throttle:verify-phone.request'])
        ->name('password.otp.request');
    
    Route::view('reset-password', 'auth.reset-password')
        ->name('password.reset');
    
    Route::post('reset-password', [ResetPasswordController::class, 'reset'])
        ->middleware(['throttle:10,1'])
        ->name('password.otp.update');
});

// Only for authenticated users
Route::middleware('auth')->group(function () {
    Route::get('logout', function () {
        auth()->logout();
        return redirect()->route('login');
    })->name('logout');

    Route::view('verify-phone', 'auth.verify-phone')        
        ->name('phone.verify.notice');
    
    Route::post('verify-phone', [PhoneVerificationController::class, 'verify'])
        ->middleware([
            'throttle:10,1', // max 10 attempt / menit
        ])
        ->name('phone.verify');
    
    Route::post('verify-phone/request', [PhoneVerificationController::class, 'requestOtp'])
        ->middleware([
            'throttle:verify-phone.request',
        ])
        ->name('phone.verify.request');
    
    Route::prefix('wizard')->group(function () {
        Route::get('step1', [WizardController::class, 'start'])
            ->name('wizard.start');

        Route::post('step1', [WizardController::class, 'step1'])
            ->name('wizard.step1');
        
        Route::get('step2', [WizardController::class, 'step2View'])
            ->name('wizard.step2');
    
        Route::post('step2', [WizardController::class, 'step2'])
            ->name('wizard.step2');
    });

    // Protected routes for users who have completed onboarding
    Route::middleware([EnsurePhoneIsVerified::class, 'onboarding.completed'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('invoices', [InvoiceController::class, 'showInvocePage'])->name('invoices.list');
        Route::get('invoices/{invoice}', [InvoiceController::class, 'showInvoiceDetail'])->name('invoices.detail');
        Route::get('payment/initiate', [PaymentController::class, 'initiate'])->name('payment.initiate');
    });
});
