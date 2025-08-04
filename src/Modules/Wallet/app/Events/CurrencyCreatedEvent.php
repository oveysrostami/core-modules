<?php

namespace Modules\Wallet\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\EventManager\Interfaces\LoggableEventPayloadInterface;
use Modules\EventManager\Interfaces\ShouldBeLogged;
use Modules\EventManager\Traits\ShouldBeLoggedTrait;

class CurrencyCreatedEvent implements ShouldBeLogged, LoggableEventPayloadInterface
{
    use Dispatchable, InteractsWithSockets, SerializesModels, ShouldBeLoggedTrait;

    public function __construct(public string $currency)
    {
        $this->initEventUUID();
    }

    /**
     * {@inheritdoc}
     */
    public function broadcastOn(): array
    {
        return [];
    }

    public function toLoggablePayload(): array
    {
        return ['currency' => $this->currency];
    }

    public static function fromLoggablePayload(array $payload): static
    {
        return new static($payload['currency']);
    }
}
