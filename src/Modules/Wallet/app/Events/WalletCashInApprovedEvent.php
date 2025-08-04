<?php

namespace Modules\Wallet\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\EventManager\Interfaces\LoggableEventPayloadInterface;
use Modules\EventManager\Interfaces\ShouldBeLogged;
use Modules\EventManager\Traits\ShouldBeLoggedTrait;
use Modules\Wallet\Models\WalletCashInRequest;

class WalletCashInApprovedEvent implements ShouldBeLogged,LoggableEventPayloadInterface
{
    use Dispatchable, InteractsWithSockets, SerializesModels, ShouldBeLoggedTrait;

    public function __construct(public WalletCashInRequest $request)
    {
        $this->initEventUUID();
    }

    /**
     * Get the channels the event should be broadcast on.
     */
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
        $request = WalletCashInRequest::findOrFail($payload['request_id']);

        return new static($request);
    }
}
