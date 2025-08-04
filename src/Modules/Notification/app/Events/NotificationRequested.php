<?php

namespace Modules\Notification\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\EventManager\Interfaces\LoggableEventPayloadInterface;
use Modules\EventManager\Interfaces\ShouldBeLogged;
use Modules\EventManager\Traits\ShouldBeLoggedTrait;

class NotificationRequested implements ShouldBeLogged,LoggableEventPayloadInterface
{
    use Dispatchable, InteractsWithSockets, SerializesModels,ShouldBeLoggedTrait;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public object $notifiable,
        public string $channel,
        public string $templateKey,
        public array $variables = [],
        public array $meta = []
    ) {
        $this->initEventUUID();
    }

    public function toLoggablePayload(): array
    {
        return [
            'notifiable_type' => get_class($this->notifiable),
            'notifiable_id' => $this->notifiable->getKey(),
            'channel' => $this->channel,
            'templateKey' => $this->templateKey,
            'variables' => $this->variables,
            'meta' => $this->meta,
        ];
    }

    public static function fromLoggablePayload(array $payload): static
    {
        $notifiable = app($payload['notifiable_type'])::findOrFail($payload['notifiable_id']);

        return new static(
            $notifiable,
            $payload['channel'],
            $payload['templateKey'],
            $payload['variables'],
            $payload['meta'],
        );
    }
}
