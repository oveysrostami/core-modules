<?php

namespace Modules\EventManager\Interfaces;

interface LoggableEventPayloadInterface {
    public function toLoggablePayload(): array;

    public static function fromLoggablePayload(array $payload): static;
}
