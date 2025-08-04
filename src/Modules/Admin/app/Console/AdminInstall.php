<?php

namespace Modules\Admin\Console;


use Modules\Core\Console\ModuleInstall;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class AdminInstall extends ModuleInstall
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'admin:install';

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
        $this->updateEnvValue('DEFAULT_ADMIN_EMAIL','admin@test.com');
        $this->updateEnvValue('DEFAULT_ADMIN_MOBILE_NUMBER','09301370911');
        $this->updateEnvValue('DEFAULT_ADMIN_PASSWORD','Oveys123!');
        $this->updateEnvValue('AUTH_GUARD','api');
        $this->updateEnvValue('AUTH_PASSWORD_BROKER','admins');
        $this->publishConfigFile('auth.php','auth.php');
        $this->publishConfigFile('passport.php','passport.php');
        $this->publishFile(module_path('Admin').'/publish/provider/AppServiceProvider.php',base_path('app/Providers/AppServiceProvider.php'));
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
        return 'Admin';
    }
}
