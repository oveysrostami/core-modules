<?php

namespace Modules\Wallet\Classes\DTO;

class WalletCashOutRequestDTO
{
    public function __construct(
        public int $walletId,
        public float $amount,
        public int $destinationId,
        public array $meta = []
    ) {}
}
