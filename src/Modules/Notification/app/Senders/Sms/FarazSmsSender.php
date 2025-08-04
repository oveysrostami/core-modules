<?php

namespace Modules\Notification\Senders\Sms;

use Modules\Notification\Exceptions\NotificationDispatchException;
use Modules\Notification\Interfaces\ChannelSenderInterface;
use Modules\Notification\Services\Providers\Sms\FarazSmsService;

class FarazSmsSender implements ChannelSenderInterface
{
    public function __construct(protected FarazSmsService $service) {}

    /**
     * @inheritDoc
     */
    public function send(object $notifiable, string $content, array $providerConfig, array $meta = []): void
    {
        $receptor = $notifiable->routeNotificationFor('sms');

        if (! $receptor) {
            throw new NotificationDispatchException('Receiver mobile not found.');
        }

        $apiKey = $providerConfig['token'] ?? null;
        $template = $providerConfig['template'] ?? null;

        if (! $apiKey || ! $template) {
            throw new NotificationDispatchException('Faraz SMS OTP config is incomplete.');
        }

        try {
            $this->service
                ->configure($apiKey)
                ->sendPattern(
                    mobile: $receptor,
                    templateId: $template,
                    parameters: $meta['tokens'] ?? [],
                );
        } catch (\Throwable $e) {
            throw new NotificationDispatchException('Faraz SMS send failed: ' . $e->getMessage(), 0, $e);
        }
    }
}
