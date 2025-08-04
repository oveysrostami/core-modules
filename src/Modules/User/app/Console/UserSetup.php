<?php

namespace Modules\User\Console;

use Modules\Core\Console\ModuleSetup;

class UserSetup extends ModuleSetup
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'user:setup';

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
        return 'User';
    }
}
