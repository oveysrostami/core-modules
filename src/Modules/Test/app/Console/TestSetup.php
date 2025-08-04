<?php

namespace Modules\Test\Console;

use Modules\Core\Console\ModuleSetup;

class TestSetup extends ModuleSetup
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'test:setup';

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
        return 'Admin';
    }
}
