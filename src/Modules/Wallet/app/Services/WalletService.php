<?php

namespace Modules\Wallet\Services;

use Modules\Wallet\Classes\DTO\CreateWalletsForCurrencyData;
use Modules\Wallet\Classes\DTO\CreateUserWalletsData;
use Modules\Wallet\Classes\DTO\WalletDTO;
use Modules\Wallet\Models\Wallet;
use Modules\Wallet\Services\CurrencyService;
use Nwidart\Modules\Facades\Module;
use Modules\Wallet\Traits\HasWallet;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;



class WalletService
{
    public function __construct(protected CurrencyService $currencyService)
    {
    }

    public function create(WalletDTO $data): Wallet
    {
        return Wallet::firstOrCreate(
            [
                'currency_id' => $data->currency_id,
                'walletable_type' => $data->walletableType,
                'walletable_id' => $data->walletableId,
            ],
            [
                'withdrawable_balance' => $data->withdrawableBalance,
                'non_withdrawable_balance' => $data->nonWithdrawableBalance,
                'locked_balance' => $data->lockedBalance,
            ]
        );
    }

    public function createUserWallets(CreateUserWalletsData $data): void
    {
        $currencies = $this->currencyService->all();

        foreach ($currencies as $currency) {
            $this->create(new WalletDTO(
                currency_id: $currency->id,
                walletableType: $data->user::class,
                walletableId: $data->user->id,
            ));
        }
    }
  
  /**
     * Create wallets for all walletable models for the given currency.
     */
    public function createForNewCurrency(CreateWalletsForCurrencyData $data): void
    {
        $currency = $data->currency;

        foreach ($this->getWalletableModels() as $modelClass) {
            $modelClass::query()->chunkById(100, function ($models) use ($currency, $modelClass) {
                foreach ($models as $model) {
                    Wallet::firstOrCreate(
                        [
                            'walletable_type' => $modelClass,
                            'walletable_id' => $model->getKey(),
                            'currency' => $currency,
                        ],
                        [
                            'withdrawable_balance' => 0,
                            'non_withdrawable_balance' => 0,
                            'locked_balance' => 0,
                        ]
                    );
                }
            });
        }
    }

    /**
     * @return array<int, class-string>
     */
    protected function getWalletableModels(): array
    {
        $models = [];
        $baseNamespace = config('modules.namespace') . '\\';
        foreach (Module::all() as $module) {
            $path = $module->getPath() . '/app/Models';
            if (! File::exists($path)) {
                continue;
            }

            $moduleNamespace = $baseNamespace . Str::studly($module->getName()) . '\\';
            foreach (File::allFiles($path) as $file) {
                $class = $moduleNamespace . 'Models\\' . $file->getFilenameWithoutExtension();
                if (! class_exists($class)) {
                    continue;
                }

                if (in_array(HasWallet::class, class_uses_recursive($class))) {
                    $models[] = $class;
                }
            }
        }

        return $models;
    }
}
