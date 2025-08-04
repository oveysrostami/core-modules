<?php

namespace Modules\Notification\Services\Providers\Telegram;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Modules\Notification\Exceptions\NotificationDispatchException;

class TelegramChannelService
{
    protected string $botToken;

    /**
     * @throws NotificationDispatchException
     */
    public function configure(array $config): static
    {
        $this->botToken = $config['token'] ?? '';

        if (! $this->botToken) {
            throw new NotificationDispatchException('Telegram bot_token is required.');
        }

        return $this;
    }

    /**
     * @throws NotificationDispatchException
     * @throws ConnectionException
     */
    public function sendToChannel(string $channelId, string $message, array $options = []): array
    {
        $payload = [
            'chat_id' => $channelId,
            'text' => $message,
            'parse_mode' => $options['parse_mode'] ?? 'HTML',
        ];

        if (!empty($options['disable_notification'])) {
            $payload['disable_notification'] = true;
        }

        $response = Http::post("https://api.telegram.org/bot{$this->botToken}/sendMessage", $payload);

        if ($response->failed()) {
            throw new NotificationDispatchException('Telegram send failed: ' . $response->body());
        }

        return $response->json();
    }
}
