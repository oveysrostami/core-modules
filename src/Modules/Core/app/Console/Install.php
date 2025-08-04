<?php

namespace Modules\Core\Console;

use Faker\Core\File;
use Illuminate\Console\Command;
use Modules\Core\Http\Controllers\V1\AdminBaseController;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class Install extends ModuleInstall
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'app:install';

    /**
     * The console command description.
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $modules = json_decode(file_get_contents(base_path('modules_statuses.json')));
        $commands = [];
        foreach($modules as $module=>$status) {
            if(file_exists(module_path($module).'/app/Console/'.$module.'Install.php')) {
                $commands[] = strtolower($module).":install";
            }
        }
        $this->runCommands($commands);
    }

    /**
     * Get the console command arguments.
     */
    protected function getArguments(): array
    {
        return [
            ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     */
    protected function getOptions(): array
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }

    protected function getModuleName(): string
    {
        return 'Core';
    }
}
