<?php

namespace Modules\Wallet\Listeners;

use Modules\Wallet\Classes\DTO\CreateWalletsForCurrencyData;
use Modules\Wallet\Events\CurrencyCreatedEvent;
use Modules\Wallet\Services\WalletService;

class HandleCurrencyCreated
{
    public function __construct(protected WalletService $walletService)
    {
    }

    public function handle(CurrencyCreatedEvent $event): void
    {
        $this->walletService->createForNewCurrency(
            new CreateWalletsForCurrencyData(currency: $event->currency)
        );
    }
}
