<?php

namespace Modules\EventManager\Providers;

use Illuminate\Events\CallQueuedListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Support\Facades\Event;
use Modules\EventManager\Interfaces\ShouldBeLogged;
use Modules\EventManager\Listeners\LogAllEventsListener;
use Modules\EventManager\Models\EventLog;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array<string, array<int, string>>
     */
    protected $listen = [];

    /**
     * Indicates if events should be discovered.
     *
     * @var bool
     */
    protected static $shouldDiscoverEvents = true;

    public function boot(): void
    {

        Event::listen('*', function ($eventName, array $data) {
            $event = $data[0] ?? null;

            if (! $event instanceof ShouldBeLogged) {
                return;
            }

            app(LogAllEventsListener::class)->handle($event);
        });

        Event::listen(JobProcessed::class, function (JobProcessed $event) {
            $payload = $event->job->payload();
            if($event->job->hasFailed()){
                return;
            }
            if (isset($payload['data']['command'])) {
                $command = unserialize($payload['data']['command']);
                if (
                    $command instanceof CallQueuedListener &&
                    isset($command->data[0]) &&
                    $command->data[0] instanceof ShouldBeLogged
                ) {
                    $base_event = $command->data[0];

                    EventLog::where('uuid', $base_event->uuid)->first()?->update([
                        'status' => 'succeeded',
                        'processed_at' => now(),
                    ]);
                }
            }
        });

        Event::listen(JobFailed::class, function (JobFailed $event) {
            $payload = $event->job->payload();
            if (isset($payload['data']['command'])) {
                $command = unserialize($payload['data']['command']);
                if (
                    $command instanceof CallQueuedListener &&
                    isset($command->data[0]) &&
                    $command->data[0] instanceof ShouldBeLogged
                ) {
                    $base_event = $command->data[0];
                    EventLog::where('uuid', $base_event->uuid)->first()?->update([
                        'status' => 'failed',
                        'exception' => $event->exception->getMessage(),
                        'processed_at' => now(),
                    ]);
                }
            }
        });
    }

    /**
     * Configure the proper event listeners for email verification.
     */
    protected function configureEmailVerification(): void {}
}
