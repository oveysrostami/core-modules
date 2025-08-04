<?php

namespace Modules\Wallet\Console;

use Modules\Core\Console\ModuleSetup;
use Modules\Wallet\Models\Currency;
use Modules\Wallet\Services\CurrencyService;
use Modules\Wallet\Classes\DTO\CurrencyDTO;

class WalletSetup extends ModuleSetup
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'wallet:setup';

    /**
     * The console command description.
     */
    protected $description = 'Command description.';


    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $currencyService = new CurrencyService();
        $currencyService->firstOrCreate(new CurrencyDTO(
            name: 'Iranian Rial',
            code: 'IRR',
            symbol: 'IRR'
        ));
    }

    protected function getModuleName(): string
    {
        return 'Wallet';
    }
}
