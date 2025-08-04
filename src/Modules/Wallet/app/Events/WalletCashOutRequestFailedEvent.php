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
use Modules\Wallet\Models\WalletCashOutRequest;

class WalletCashOutRequestFailedEvent implements ShouldBeLogged,LoggableEventPayloadInterface
{
    use Dispatchable, InteractsWithSockets, SerializesModels, ShouldBeLoggedTrait;

    public WalletCashOutRequest $request;

    /**
     * Create a new event instance.
     */
    public function __construct(WalletCashOutRequest $request)
    {
        $this->request = $request;
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
            'wallet_cash_out_request_id' => $this->request->id,
        ];
    }

    public static function fromLoggablePayload(array $payload): static
    {
        $request = WalletCashOutRequest::findOrFail($payload['wallet_cash_out_request_id']);
        return new static($request);
    }
}
