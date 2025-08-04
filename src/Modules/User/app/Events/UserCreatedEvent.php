<?php

namespace Modules\User\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\EventManager\Interfaces\LoggableEventPayloadInterface;
use Modules\EventManager\Interfaces\ShouldBeLogged;
use Modules\EventManager\Traits\ShouldBeLoggedTrait;
use Modules\User\Models\User;

class UserCreatedEvent implements ShouldBeLogged, LoggableEventPayloadInterface
{
    use Dispatchable, InteractsWithSockets, SerializesModels, ShouldBeLoggedTrait;

    public function __construct(public User $user)
    {
        $this->initEventUUID();
    }

    public function toLoggablePayload(): array
    {
        return [
            'user_id' => $this->user->getKey(),
        ];
    }

    public static function fromLoggablePayload(array $payload): static
    {
        $user = User::findOrFail($payload['user_id']);

        return new static($user);
    }
}
