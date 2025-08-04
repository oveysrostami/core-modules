<?php

namespace Modules\Wallet\Console;

use Modules\Core\Console\ModuleInstall;

class WalletInstall extends ModuleInstall
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'wallet:install';

    /**
     * The console command description.
     */
    protected $description = 'Command description.';


    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->ensurePackageInstalled('shetabit/payment',['php artisan vendor:publish --tag=payment-config','php artisan vendor:publish --tag=payment-views']);
        $this->publishConfigFile('payment.php','payment.php');
        $this->updateEnvValue('JIBIT_API_KEY','YOUR_JIBIT_API_KEY');
        $this->updateEnvValue('JIBIT_SECRET_KEY','YOUR_JIBIT_SECRET_KEY');
        $this->updateEnvValue('JIBIT_CALLBACK_URL','YOUR_JIBIT_CALLBACK_URL');
    }

    protected function getModuleName(): string
        {
            return 'Wallet';
        }

}
