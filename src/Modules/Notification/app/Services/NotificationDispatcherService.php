<?php

namespace Modules\Notification\Services;

use Illuminate\Support\Facades\Log;
use JetBrains\PhpStorm\NoReturn;
use Modules\Core\Exceptions\ApiException;
use Modules\Notification\Interfaces\ChannelSenderInterface;

class NotificationDispatcherService
{
    public function __construct(
        protected NotificationTemplateResolverService $templateResolver,
        protected NotificationProviderResolverService $providerResolver
    ) {}

    /**
     * @throws \Throwable
     */
    #[NoReturn] public function dispatch(object $notifiable, string $channel, string $templateKey, array $variables = [], array $meta = []): void
    {
        $log = $notifiable->notifiable()->create([
                'channel' => $channel,
                'template_key' => $templateKey,
                'status' => 'pending',
                'payload' => [],
            ]);
        try {
            $template = $this->templateResolver->resolve($channel, $templateKey, $variables);

            $providers = $this->providerResolver->resolve($channel, $templateKey);

            $sent = false;
            foreach ($providers as $provider) {
                /** @var ChannelSenderInterface $sender */
                $sender = app()->make("notification.channel_sender.{$channel}.{$provider->name}");

                if (! $sender instanceof ChannelSenderInterface) {
                    continue;
                }
                try {
                    $sender->send($notifiable, $template, $provider->config, $meta);

                    $log->update([
                        'provider' => $provider->name,
                        'status' => 'sent',
                        'sent_at' => now(),
                        'payload' => [
                            'to' => $notifiable->routeNotificationFor($channel),
                            'content' => $template,
                            'provider' => $provider->name,
                        ],
                    ]);

                    $sent = true;
                    break;
                } catch (\Throwable $e) {
                    Log::warning("Notification send failed with provider {$provider->name}: " . $e->getMessage());
                    continue;
                }
            }

            if (! $sent) {
                throw new ApiException('provider.failed',['channel' => $channel],500,'notification');
            }

        } catch (\Throwable $e) {
            $log->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);

            report($e);
            throw $e; // ✅ این خط مهمه
        }
    }
}
