<?php

namespace Modules\Wallet\Classes\Validator;

use Modules\Wallet\Rules\CompareWithdrawbleAmountAndInputAmount;

class CashOutRequestValidator
{
    public static function rules(): array
    {
        return [
            'wallet_id' => ['required','exists:wallets,id'],
            'amount' => ['required', 'integer', 'min:1000' , new CompareWithdrawbleAmountAndInputAmount],
            'destination_id' =>['required', 'exists:bank_accounts,id']
        ];
    }
}
