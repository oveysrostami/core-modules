<?php

namespace Modules\Wallet\Listeners;

use Modules\User\Events\UserCreatedEvent;
use Modules\Wallet\Classes\DTO\CreateUserWalletsData;
use Modules\Wallet\Services\WalletService;

class HandleUserCreated
{
    public function __construct(protected WalletService $walletService)
    {
    }

    public function handle(UserCreatedEvent $event): void
    {
        $this->walletService->createUserWallets(
            new CreateUserWalletsData(
                user: $event->user,
            )
        );
    }
}

