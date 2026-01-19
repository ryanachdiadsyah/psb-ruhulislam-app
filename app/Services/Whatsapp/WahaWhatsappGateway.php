<?php

namespace App\Services\Whatsapp;

use Illuminate\Support\Facades\Http;

class WahaWhatsappGateway implements WhatsappGateway
{
    public function send(string $phoneNumber, string $message): bool
    {
        $config = config('whatsapp.waha');

        $phone = PhoneNormalizer::toWaha($phoneNumber);

        $response = Http::withBasicAuth(
                $config['username'],
                $config['password']
            )
            ->timeout($config['timeout'])
            ->post($config['base_url'].'/send/message', [
                'phone'   => $phone,
                'message' => $message,
            ]);

        if (! $response->successful()) {
            \Log::error('WAHA SEND FAILED', [
                'phone' => $phone,
                'status' => $response->status(),
                'response' => $response->body(),
            ]);
        }

        return $response->successful();
    }

    public function presence(string $phoneNumber, string $action): bool
    {
        if (! in_array($action, ['start', 'stop'], true)) {
            throw new \InvalidArgumentException('Invalid presence action');
        }

        $config = config('whatsapp.waha');
        $phone = PhoneNormalizer::toWaha($phoneNumber);

        $response = Http::withBasicAuth(
                $config['username'],
                $config['password']
            )
            ->timeout($config['timeout'] ?? 5)
            ->post($config['base_url'].'/send/chat-presence', [
                'phone'  => $phone,
                'action' => $action,
            ]);

        return $response->successful();
    }

}