<?php

namespace Modules\Wallet\Classes\DTO;

class WalletPurchaseRequestDTO
{
    public function __construct(
        public int $walletId,
        public float $amount,
        public string $purchasableType,
        public int $purchasableId,
        public array $meta = []
    ) {}
}
