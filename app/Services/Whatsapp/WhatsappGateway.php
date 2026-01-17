<?php

namespace App\Services\Whatsapp;

interface WhatsappGateway
{
    public function send(string $phoneNumber, string $message): bool;
}