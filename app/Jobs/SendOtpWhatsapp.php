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

    public function __construct(string $phone, string $message)
    {
        $this->phone = $phone;
        $this->message = $message;
    }

    public function handle(WhatsappGateway $wa): void
    {
        // typing start
        $wa->presence($this->phone, 'start');

        sleep(rand(3, 5));

        // send message
        $wa->send($this->phone, $this->message);

        sleep(1);

        // typing stop
        $wa->presence($this->phone, 'stop');
    }
}
