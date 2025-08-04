<?php

namespace Modules\Wallet\Classes\DTO;

class CurrencyDTO
{
    public function __construct(
        public string $name,
        public string $code,
        public ?string $symbol = null,
    ) {
    }
}
