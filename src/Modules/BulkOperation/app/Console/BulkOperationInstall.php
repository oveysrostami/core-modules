<?php

namespace Modules\BulkOperation\Console;

use Modules\Core\Console\ModuleInstall;

class BulkOperationInstall extends ModuleInstall
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'bulkoperation:install';

    /**
     * The console command description.
     */
    protected $description = 'Command description.';


    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->ensurePackageInstalled('phpoffice/phpspreadsheet');
    }

    protected function getModuleName(): string
        {
            return 'BulkOperation';
        }

}
