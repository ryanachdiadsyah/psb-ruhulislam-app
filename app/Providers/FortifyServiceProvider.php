<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Auth;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Fortify::registerView(function () {
            return view('auth.register');
        });

        Fortify::validateRegistrationUsing(function (Request $request) {
            Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'phone_number' => [
                    'required',
                    'string',
                    'regex:/^08[0-9]{8,11}$/',
                    'unique:users,phone_number',
                ],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ])->validate();
        });

        // ✅ LOGIN RATE LIMITER (WAJIB ADA SEBELUM AUTH)
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by(
                $request->input('phone_number') ?: $request->ip()
            );
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by(
                $request->session()->get('login.id')
            );
        });

        // ✅ LOGIN VIA PHONE NUMBER
        Fortify::authenticateUsing(function (Request $request) {
            return Auth::attempt([
                'phone_number' => $request->phone_number,
                'password' => $request->password,
            ]) ? Auth::user() : null;
        });

        // Default Fortify actions (biarkan)
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
    }
}
