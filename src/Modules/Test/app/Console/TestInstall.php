<?php

namespace Modules\Test\Console;

use Modules\Core\Console\ModuleInstall;

class TestInstall extends ModuleInstall
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'test:install';

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
            return 'Test';
        }

}
