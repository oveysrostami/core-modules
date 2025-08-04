<?php

namespace Modules\Notification\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use JetBrains\PhpStorm\NoReturn;
use Modules\Notification\Events\NotificationRequested;
use Modules\Notification\Services\NotificationDispatcherService;

class SendNotification implements ShouldQueue
{
    public string $queue = 'notifications';
    public function __construct(protected NotificationDispatcherService $dispatcher) {}

    /**
     * @throws \Throwable
     */
    #[NoReturn] public function handle(NotificationRequested $event): void
    {
        $this->dispatcher->dispatch(
            $event->notifiable,
            $event->channel,
            $event->templateKey,
            $event->variables,
            $event->meta
        );
    }
}
