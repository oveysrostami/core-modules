<?php

namespace Modules\Notification\Senders\Sms;

use Modules\Notification\Interfaces\ChannelSenderInterface;

class SmsIrSmsSender implements ChannelSenderInterface
{

    /**
     * @inheritDoc
     */
    public function send(object $notifiable, string $content, array $providerConfig, array $meta = []): void
    {
        // TODO: Implement send() method.
    }
}
