<?php

namespace Modules\Test\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use JetBrains\PhpStorm\NoReturn;
use Modules\Admin\Models\Admin;
use Modules\Notification\Events\NotificationRequested;
use Modules\Notification\Services\NotificationDispatcherService;

class NotifyOnSomethingHappenedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    #[NoReturn] public function handle(): void
    {
        
    }
}
