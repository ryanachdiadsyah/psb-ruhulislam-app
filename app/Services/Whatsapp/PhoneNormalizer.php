<?php

namespace App\Services\Whatsapp;

class PhoneNormalizer
{
    public static function toWaha(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        return $phone . '@s.whatsapp.net';
    }
}