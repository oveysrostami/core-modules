<?php

namespace Modules\Notification\Console;

use Modules\Core\Console\ModuleInstall;

class NotificationInstall extends ModuleInstall
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'notification:install';

    /**
     * The console command description.
     */
    protected $description = 'Command description.';


    /**
     * Execute the console command.
     */
    public function handle(): void
    {

    }

    protected function getModuleName(): string
    {
        return 'Notification';
    }

}
