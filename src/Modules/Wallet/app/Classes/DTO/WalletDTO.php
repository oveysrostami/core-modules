<?php

namespace Modules\Wallet\Classes\DTO;

class WalletDTO
{
    public function __construct(
        public int $currency_id,
        public float $withdrawableBalance = 0,
        public float $nonWithdrawableBalance = 0,
        public float $lockedBalance = 0,
        public string $walletableType,
        public int $walletableId,
    ) {}
}
