<?php

namespace Modules\Wallet\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Modules\Wallet\Models\Wallet;

class CompareWithdrawbleAmountAndInputAmount implements DataAwareRule, ValidationRule
{
    /**
     * All the data under validation.
     *
     * @var array<string, mixed>
     */
    protected array $data = [];

    // ...

    /**
     * Set the data under validation.
     *
     * @param  array<string, mixed>  $data
     */
    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void {
        $wallet = null;
        if(isset($this->data['wallet_id']))
            $wallet = Wallet::find($this->data['wallet_id']);
        else if (isset($this->data['from_wallet_id']))
            $wallet = Wallet::find($this->data['from_wallet_id']);

        if ($wallet) {
            if ($wallet->withdrawable_balance < $value) {
                $fail('wallet::message.errors.wallet.balance.not_enough');
            }
        } else {
            $fail('wallet::message.errors.wallet.not_found');
        }
    }
}
