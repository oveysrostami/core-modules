<?php

namespace Modules\Wallet\Traits;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Wallet\Models\Transaction;

trait HasTransaction
{
    public function transaction(): MorphOne
    {
        return $this->morphOne(Transaction::class, 'transactionable');
    }

}
