<?php

namespace Modules\Wallet\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Modules\Wallet\Models\Wallet;

class CompareSourceDestinationCurrencyForTransfer implements DataAwareRule,ValidationRule
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
     * @param array<string, mixed> $data
     */
    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $fromWallet = Wallet::find($this->data['from_wallet_id']);
        $toWallet = Wallet::find($this->data['to_wallet_id']);
        if ($fromWallet && $toWallet && $fromWallet->currency_id !== $toWallet->currency_id) {
            $fail('wallet::message.errors.wallet.not_match.source_currency_destination_currency');
        }
    }
}
