<?php

namespace Modules\User\Console;

use Modules\Core\Console\ModuleInstall;

class UserInstall extends ModuleInstall
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'user:install';

    /**
     * The console command description.
     */
    protected $description = 'Command description.';


    /**
     * Execute the console command.
     */
    public function handle() {}

    protected function getModuleName(): string
        {
            return 'User';
        }

}
