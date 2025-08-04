<?php

namespace Modules\FileManager\Console;

use Modules\Core\Console\ModuleSetup;

class FileManagerSetup extends ModuleSetup
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'filemanager:setup';

    /**
     * The console command description.
     */
    protected $description = 'Setup tasks for FileManager module.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('FileManager setup completed.');
    }

    protected function getModuleName(): string
    {
        return 'FileManager';
    }
}
