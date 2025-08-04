<?php

namespace Modules\Wallet\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Wallet\Models\BankAccount;

trait HasBankAccount
{
    public function bankAccounts(): MorphMany
    {
        return $this->morphMany(BankAccount::class, 'bankaccountable');
    }

    public function defaultBankAccount(): ?BankAccount
    {
        return $this->bankAccounts()->where('is_default', true)->first();
    }
}
