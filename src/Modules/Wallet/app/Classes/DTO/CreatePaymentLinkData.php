<?php

namespace Modules\Wallet\Classes\DTO;

class CreatePaymentLinkData
{
    public function __construct(
        public string $mobile_number,
        public float $amount,
        public ?int $gateway_id = null,
    ) {
    }
}
