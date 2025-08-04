<?php

namespace Modules\Wallet\Classes\DTO;

class UpdatePaymentLinkData
{
    public function __construct(
        public ?float $amount = null,
        public ?int $gateway_id = null,
    ) {
    }
}
