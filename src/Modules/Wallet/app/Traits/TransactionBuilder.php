<?php

namespace Modules\Wallet\Traits;

use Illuminate\Database\Eloquent\Model;
use Modules\Wallet\Classes\DTO\TransactionDTO;
use Modules\Wallet\Enums\TransactionType;
use Modules\Wallet\Models\Transaction;
use Modules\Wallet\Models\Wallet;
use Modules\Wallet\Services\TransactionService;

trait TransactionBuilder {
    public function cashOut(Wallet $wallet, float $amount, string $desc, Model $transactionable, array $meta = []): Transaction
    {
        return app(TransactionService::class)->create(new TransactionDTO(
            walletId: $wallet->id,
            amount: $amount,
            type: TransactionType::CASH_OUT->value,
            isWithdrawable: false,
            description: $desc,
            transactionableType: $transactionable::class,
            transactionableId: $transactionable->id,
            meta: $meta
        ));
    }

    public function cashIn(Wallet $wallet, float $amount, string $desc, Model $transactionable, array $meta = []): Transaction
    {
        return app(TransactionService::class)->create(new TransactionDTO(
            walletId: $wallet->id,
            amount: $amount,
            type: TransactionType::CASH_IN->value,
            isWithdrawable: true,
            description: $desc,
            transactionableType: $transactionable::class,
            transactionableId: $transactionable->id,
            meta: $meta
        ));
    }
}
