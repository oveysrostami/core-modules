<?php

namespace Modules\Wallet\Classes\DTO;

class TransactionDTO
{
    public function __construct(
        public int $walletId,
        public float $amount,
        public string $type, // enum: cash_in / cash_out
        public bool $isWithdrawable = false,
        public string $description = '',
        public ?string $transactionableType = null,
        public ?int $transactionableId = null,
        public array $meta = [],
    ) {}
}
