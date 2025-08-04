<?php

namespace Modules\Notification\Senders\Internal;

use Modules\Notification\Interfaces\ChannelSenderInterface;

class InAppNotificationSender implements ChannelSenderInterface
{
    public function send(object $notifiable, string $content, array $providerConfig, array $meta = []): void
    {
        $notifiable->notifyInternally(
            type:"in_app",
            title:$meta['title'],
            message:$content,
            data:$meta,
        );
    }
}
