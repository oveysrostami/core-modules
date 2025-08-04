<?php

namespace Modules\Wallet\Classes\DTO;

class WalletTransferRequestDTO
{
    public function __construct(
        public int $fromWalletId,
        public int $toWalletId,
        public float $amount,
        public array $meta = []
    ) {}
}
