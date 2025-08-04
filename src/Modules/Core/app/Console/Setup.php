<?php

namespace Modules\Core\Console;

use Illuminate\Support\Facades\File;

class Setup extends ModuleSetup
{
    protected $signature = 'app:setup';
    protected $description = 'Setup initial config for Core module';

    public function handle(): void
    {
        $this->info("🚀 اجرای setup برای ماژول Core...");
        $this->cacheClear();
        $this->setup();
        $this->runModuleSetup();
        $this->cacheClear();
        $this->runCommands(['horizon:clear --force']);
        $this->info("✅ Application setup completed.");


    }
    private function runModuleSetup(): void
    {
        $modules = json_decode(file_get_contents(base_path('modules_statuses.json')));
        $commands = [];
        foreach($modules as $module=>$status) {
            if(file_exists(module_path($module).'/app/Console/'.$module.'Setup.php')) {
                $commands[] = strtolower($module).":setup";
            }
        }
        $this->runCommands($commands);
    }




    protected function getModuleName(): string
    {
        return 'Core';
    }
}
