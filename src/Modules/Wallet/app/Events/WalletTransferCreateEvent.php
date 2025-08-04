<?php

namespace Modules\Wallet\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\EventManager\Interfaces\LoggableEventPayloadInterface;
use Modules\EventManager\Interfaces\ShouldBeLogged;
use Modules\EventManager\Traits\ShouldBeLoggedTrait;
use Modules\Wallet\Models\WalletTransferRequest;

class WalletTransferCreateEvent implements ShouldBeLogged, LoggableEventPayloadInterface
{
    use Dispatchable, InteractsWithSockets, SerializesModels, ShouldBeLoggedTrait;

    public function __construct(public WalletTransferRequest $request)
    {
        $this->initEventUUID();
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }

    public function toLoggablePayload(): array
    {
        return [
            'request_id' => $this->request->getKey(),
        ];
    }

    public static function fromLoggablePayload(array $payload): static
    {
        $request = WalletTransferRequest::findOrFail($payload['request_id']);

        return new static($request);
    }
}
