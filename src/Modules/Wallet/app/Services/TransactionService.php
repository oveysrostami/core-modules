<?php

namespace Modules\Wallet\Services;


use Modules\Wallet\Classes\DTO\TransactionDTO;
use Modules\Wallet\Models\Transaction;

class TransactionService
{
    public function create(TransactionDTO $dto): Transaction
    {
        return Transaction::create([
            'wallet_id' => $dto->walletId,
            'type' => $dto->type,
            'amount' => $dto->amount,
            'is_withdrawable' => $dto->isWithdrawable,
            'description' => $dto->description,
            'transactionable_type' => $dto->transactionableType,
            'transactionable_id' => $dto->transactionableId,
            'meta' => $dto->meta,
        ]);
    }
}
