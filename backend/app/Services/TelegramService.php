<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TelegramService
{
    protected $token;

    public function __construct()
    {
        $this->token = config('services.telegram.bot_token') ?: env('TELEGRAM_BOT_TOKEN');
    }

    public function sendMessage(string $chatId, string $text)
    {
        if (! $this->token || ! $chatId) {
            return false;
        }

        $url = "https://api.telegram.org/bot{$this->token}/sendMessage";

        $res = Http::post($url, [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML'
        ]);

        return $res->successful();
    }
}
