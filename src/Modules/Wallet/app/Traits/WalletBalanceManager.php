<?php

namespace Modules\Wallet\Traits;

use Modules\Wallet\Models\Wallet;

trait WalletBalanceManager {
    public function lockAmount(Wallet $wallet, float $amount): void
    {
        $wallet->decrement('withdrawable_balance', $amount);
        $wallet->increment('locked_balance', $amount);
    }

    public function releaseLockedAmount(Wallet $wallet, float $amount): void
    {
        $wallet->decrement('locked_balance', $amount);
        $wallet->increment('withdrawable_balance', $amount);
    }

    public function applyDeposit(Wallet $wallet, float $amount): void
    {
        $wallet->increment('withdrawable_balance', $amount);
    }
}
