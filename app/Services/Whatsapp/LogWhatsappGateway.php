<?php

namespace App\Services\Whatsapp;

use Illuminate\Support\Facades\Log;

class LogWhatsappGateway implements WhatsappGateway
{
    public function send(string $phoneNumber, string $message): bool
    {
        Log::info('[WA MOCK]', [
            'to' => $phoneNumber,
            'message' => $message,
        ]);

        return true;
    }

    public function presence(string $phoneNumber, string $action): bool
    {
        Log::info('[WA MOCK PRESENCE]', [
            'to' => $phoneNumber,
            'action' => $action,
        ]);

        return true;
    }

    
}