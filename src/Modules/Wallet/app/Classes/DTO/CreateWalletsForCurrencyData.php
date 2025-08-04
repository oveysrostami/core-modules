<?php

namespace Modules\Wallet\Classes\DTO;

class CreateWalletsForCurrencyData
{
    public function __construct(public string $currency)
    {
    }
}
