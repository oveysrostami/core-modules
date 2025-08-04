<?php

namespace Modules\Acl\Console;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;
use Modules\Core\Console\ModuleInstall;
use Modules\Core\Console\ModuleSetup;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class AclInstall extends ModuleInstall
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'acl:install';

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
     * @throws FileNotFoundException
     */
    public function handle(): void
    {
        $this->ensurePackageInstalled('spatie/laravel-permission');
        $this->publishConfigFile('permission.php','permission.php');

        $appFile = base_path('bootstrap/app.php');
        $content = file_get_contents($appFile);

        $stubPath = module_path('acl') . '/publish/bootstrap/middleware.stub';
        $injection = File::get($stubPath);

        if (!str_contains($content, "'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class")) {
            if (preg_match('/->withMiddleware\(\s*function\s*\(Middleware\s*\$middleware\): void\s*\{\s*/', $content, $match, PREG_OFFSET_CAPTURE)) {
                $insertPos = $match[0][1] + strlen($match[0][0]);
                $content = substr_replace($content, $injection . "\n\n", $insertPos, 0);

                file_put_contents($appFile, $content);
                $this->info('Middleware aliases for Spatie injected into bootstrap/app.php from stub.');
            } else {
                $this->warn('Could not find ->withMiddleware() block to inject middleware aliases.');
            }
        } else {
            $this->info('Spatie middleware aliases already registered.');
        }
    }

    protected function getModuleName(): string
    {
        return "Acl";
    }
}
