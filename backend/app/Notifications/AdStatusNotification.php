<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Services\TelegramService;

class AdStatusNotification extends Notification
{
    use Queueable;

    protected $ad;
    protected $message;

    public function __construct($ad, $message = null)
    {
        $this->ad = $ad;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['telegram'];
    }

    public function toTelegram($notifiable)
    {
        $telegram = new TelegramService();
        $chatId = config('services.telegram.chat_id') ?: env('TELEGRAM_CHAT_ID');
        $text = $this->message ?? "Ad #{$this->ad->id} status: {$this->ad->status}";
        $telegram->sendMessage($chatId, $text);
    }
}
