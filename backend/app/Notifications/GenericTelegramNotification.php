<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class GenericTelegramNotification extends Notification
{
    use Queueable;

    protected $text;

    public function __construct($text)
    {
        $this->text = $text;
    }

    public function via($notifiable)
    {
        return ['telegram'];
    }

    public function toTelegram($notifiable)
    {
        $service = new \App\Services\TelegramService();
        $chatId = config('services.telegram.chat_id') ?: env('TELEGRAM_CHAT_ID');
        $service->sendMessage($chatId, $this->text);
    }
}
