<?php

namespace Modules\FileManager\Console;

use Modules\Core\Console\ModuleInstall;

class FileManagerInstall extends ModuleInstall
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'filemanager:install';

    /**
     * The console command description.
     */
    protected $description = 'Command description.';


    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->ensurePackageInstalled('league/flysystem-aws-s3-v3:"^3.0" --with-all-dependencies');
        $this->ensurePackageInstalled('ext-imagick');
        $this->updateEnvValue('AWS_ACCESS_KEY_ID','YOUR_ACCESS_KEY_ID');
        $this->updateEnvValue('AWS_SECRET_ACCESS_KEY','YOUR_SECRET_ACCESS_KEY');
        $this->updateEnvValue('AWS_DEFAULT_REGION','us-east-1');
        $this->updateEnvValue('AWS_PUBLIC_BUCKET','YOUR_PUBLIC_BUCKET');
        $this->updateEnvValue('AWS_PRIVATE_BUCKET','YOUR_PRIVATE_BUCKET');
        $this->updateEnvValue('AWS_USE_PATH_STYLE_ENDPOINT','true');
        $this->updateEnvValue('FILESYSTEM_DISK','s3_public');
        $this->updateEnvValue('APP_CDN_URL','YOUR_CDN_URL');
        $this->publishConfigFile('filesystems.php','filesystems.php');
    }

    protected function getModuleName(): string
        {
            return 'FileManager';
        }

}
