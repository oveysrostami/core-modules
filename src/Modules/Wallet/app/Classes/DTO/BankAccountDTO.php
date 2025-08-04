<?php

namespace Modules\Wallet\Classes\DTO;

class BankAccountDTO
{
    public function __construct(
        public string  $bankName,
        public string  $cardNumber,
        public ?string $iban = null,
        public ?string $accountNumber = null,
        public bool    $isDefault = false,
    )
    {
    }
}
