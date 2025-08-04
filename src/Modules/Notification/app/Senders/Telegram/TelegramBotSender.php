<?php

namespace Modules\Notification\Senders\Telegram;

use Modules\Notification\Interfaces\ChannelSenderInterface;
use Modules\Notification\Services\Providers\Telegram\TelegramChannelService;

class TelegramBotSender implements ChannelSenderInterface
{
    public function __construct(protected TelegramChannelService $service)
    {
    }

    public function send(object $notifiable, string $content, array $providerConfig, array $meta = []): void
    {
        $this->service->
        configure($providerConfig)
            ->sendToChannel($meta['chat_id'],$content);
    }
}
