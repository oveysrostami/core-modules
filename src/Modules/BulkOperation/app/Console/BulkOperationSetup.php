<?php

namespace Modules\BulkOperation\Console;

use Modules\Core\Console\ModuleSetup;
use Modules\BulkOperation\Models\BulkOperationType;

class BulkOperationSetup extends ModuleSetup
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'bulkoperation:setup';

    /**
     * The console command description.
     */
    protected $description = 'Command description.';


    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        BulkOperationType::firstOrCreate(
            ['type' => 'import_user'],
            ['requires_admin_approval' => false]
        );
    }

    protected function getModuleName(): string
    {
        return 'BulkOperation';
    }
}
