<?php

namespace Modules\Wallet\Classes\Validator;

use Modules\Wallet\Rules\CompareSourceDestinationCurrencyForTransfer;
use Modules\Wallet\Rules\CompareWithdrawbleAmountAndInputAmount;

class CashTransferRequestValidator
{
    public static function rules(bool $forAdmin = false): array
    {
        return [
            'from_wallet_id' => ['required', 'exists:wallets,id'],
            'to_wallet_id' => ['required', 'exists:wallets,id', 'different:from_wallet_id' , new CompareSourceDestinationCurrencyForTransfer],
            'amount' => ['required', 'integer', 'min:1000',new CompareWithdrawbleAmountAndInputAmount],
        ];
    }
}
