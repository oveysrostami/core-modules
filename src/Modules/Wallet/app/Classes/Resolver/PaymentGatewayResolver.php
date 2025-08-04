<?php

namespace Modules\Wallet\Classes\Resolver;

use Modules\Wallet\Models\PaymentGateway;

class PaymentGatewayResolver
{
    public function resolve(PaymentGateway $gateway): void
    {
        config([
            'payment.default' => $gateway->driver,
            'payment.drivers.' . $gateway->driver . 'currency' => $gateway->currency?->code ?? 'R',
        ]);
        \Artisan::call('config:clear');
    }
}
