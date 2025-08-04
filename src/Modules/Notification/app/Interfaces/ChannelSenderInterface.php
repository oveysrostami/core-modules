<?php

namespace Modules\Notification\Interfaces;

use Exception;

interface ChannelSenderInterface
{
    /**
     * Send a notification message using a specific provider.
     *
     * @param object $notifiable The entity that will receive the notification.
     * @param string $content The rendered content of the notification.
     * @param array $providerConfig The provider configuration array (API keys, credentials, etc).
     * @param array $meta Optional meta data (like subject for email, or parse_mode for Telegram).
     * @return void
     *
     * @throws Exception If sending fails.
     */
    public function send(object $notifiable, string $content, array $providerConfig, array $meta = []): void;
}
