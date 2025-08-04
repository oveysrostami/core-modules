<?php

namespace Modules\Wallet\Traits;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Wallet\Models\Wallet;

trait HasWallet
{
    public function wallet(): MorphOne
    {
        return $this->morphOne(Wallet::class, 'walletable');
    }
}
