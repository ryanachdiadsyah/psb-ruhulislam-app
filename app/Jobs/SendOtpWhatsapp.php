<?php

namespace App\Jobs;

use App\Services\Whatsapp\WhatsappGateway;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendOtpWhatsapp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $phone;
    public string $message;

    public $tries = 3;
    public $backoff = [10, 30, 60];

    public function __construct(string $phone, string $message)
    {
        $this->onQueue('otp');
        $this->phone = $phone;
        $this->message = $message;
    }

    public function handle(WhatsappGateway $wa): void
    {
        try {
            $wa->presence($this->phone, 'start');

            sleep(rand(3, 5));

            if (! $wa->send($this->phone, $this->message)) {
                throw new \Exception('WA send failed');
            }

            sleep(1);
        } finally {
            $wa->presence($this->phone, 'stop');
        }
    }

    public function failed(\Throwable $e): void
    {
        \Log::error('OTP WA FAILED', [
            'phone' => $this->phone,
            'error' => $e->getMessage(),
        ]);
    }
}
