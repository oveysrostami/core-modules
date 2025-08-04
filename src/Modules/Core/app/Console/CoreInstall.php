<?php

namespace Modules\Core\Console;

use Illuminate\Support\Facades\File;

class CoreInstall extends ModuleInstall
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'core:install';

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
        $this->removeUnusedFile();
        $this->updateEnv();
        \File::copyDirectory( module_path($this->getModuleName()).'/publish/stubs', base_path('stubs'));
        \File::copyDirectory( module_path($this->getModuleName()).'/publish/lang', base_path('lang'));
        if(!file_exists(base_path('routes/api.php'))) {
            $commands = [
                'install:api --passport --force',
            ];
            $this->runCommands($commands);
        }
        $this->ensurePackageInstalled('laravel/horizon' , ['php artisan horizon:install']);
        $this->ensurePackageInstalled('spatie/laravel-query-builder',['php artisan vendor:publish --provider="Spatie\QueryBuilder\QueryBuilderServiceProvider" --tag="query-builder-config"']);
        $this->ensurePackageInstalled('morilog/jalali:dev-master');
        $this->ensurePackageInstalled('predis/predis');
        $this->updateConfig();
    }
    private function updateConfig(): void
    {
        $defaultConfigPath = module_path('Core') . '/publish/config/';
        $files = glob($defaultConfigPath . '*.php');
        foreach ($files as $filePath) {
            $filename = basename($filePath);
            $this->publishConfigFile($filename, $filename);
            $this->info("Config file {$filename} published");
        }
    }
    private function updateEnv(): void
    {
        $this->updateEnvValue('APP_ENV', 'local');
        $this->updateEnvValue('APP_URL', 'http://127.0.0.1:8000');
        $this->updateEnvValue('APP_DOMAIN', '127.0.0.1:8000');
        $this->updateEnvValue('APP_LOCALE', 'fa');
        $this->updateEnvValue('APP_FALLBACK_LOCALE', 'fa');
        $this->updateEnvValue('APP_FAKER_LOCALE', 'fa_IR');
        $this->updateEnvValue('QUEUE_CONNECTION', 'redis');
        $this->updateEnvValue('CACHE_STORE', 'redis');
        $this->updateEnvValue('CACHE_PREFIX', 'system_cache_');
    }
    private function removeUnusedFile(): void
    {
        //Remove UnUsed File
        File::deleteDirectory(base_path('app/Models'));
        File::deleteDirectory(base_path('database/factories'));
        File::delete(base_path('database/migrations/0001_01_01_000000_create_users_table.php'));
        File::delete(base_path('vite.config.js'));
        File::delete(base_path('vite-module-loader.js'));
        File::delete(base_path('package.json'));
    }

    protected function getModuleName(): string
    {
        return 'Core';
    }
}
