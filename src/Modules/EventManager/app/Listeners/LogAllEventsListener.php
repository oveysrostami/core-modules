<?php

namespace Modules\EventManager\Listeners;

use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;
use Modules\EventManager\Interfaces\LoggableEventPayloadInterface;
use Modules\EventManager\Models\EventLog;

class LogAllEventsListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event): void
    {
        try {
            $payload = $event instanceof LoggableEventPayloadInterface
                ? $event->toLoggablePayload()
                : (array) $event;

            EventLog::create([
                'uuid' => $event->uuid ?? Str::uuid(),
                'event_name' => get_class($event),
                'status' => 'dispatched',
                'payload' => $payload,
                'dispatched_at' => now(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to log event: ' . get_class($event), [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);
        }
    }
}
