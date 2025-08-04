<?php

namespace Modules\Wallet\Classes\DTO;

class WalletCashInRequestDTO
{
    public function __construct(
        public int $walletId,
        public float $amount,
        public ?int $gatewayId = null,
        public ?string $reason = null,
        public bool $isWithdrawable = false,
        public ?string $cardNumber = null,
        public array $meta = []
    ) {}
}
