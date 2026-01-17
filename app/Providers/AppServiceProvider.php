<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Whatsapp\WhatsappGateway;
use App\Services\Whatsapp\LogWhatsappGateway;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(WhatsappGateway::class, LogWhatsappGateway::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
