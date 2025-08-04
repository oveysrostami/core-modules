<?php

namespace Modules\Notification\app\Senders\Sms;

use Modules\Notification\Exceptions\NotificationDispatchException;
use Modules\Notification\Interfaces\ChannelSenderInterface;
use Modules\Notification\Services\Providers\Sms\KavehnegarService;

class KavenegarSmsSender implements ChannelSenderInterface
{
    public function __construct(protected KavehnegarService $service) {}

    /**
     * @inheritDoc
     */
    public function send(object $notifiable, array|string $content, array $providerConfig, array $meta = []): void
    {
        $receptor = $notifiable->routeNotificationFor('sms');

        if (! $receptor) {
            throw new NotificationDispatchException('Receiver mobile not found.');
        }

        $apiKey = $providerConfig['token'] ?? null;
        $template = $providerConfig['template'] ?? null;

        if (! $apiKey || ! $template) {
            throw new NotificationDispatchException('Kavenegar OTP config is incomplete.');
        }

        try {
            $this->service
                ->configure($apiKey)
                ->sendPattern(
                    mobile: $receptor,
                    templateId: $template,
                    parameters: is_array($content) ? $content : [$content], // مثلاً کد OTP
                );
        } catch (\Throwable $e) {
            throw new NotificationDispatchException("Kavenegar OTP failed: " . $e->getMessage(), 0, $e);
        }
    }
}
