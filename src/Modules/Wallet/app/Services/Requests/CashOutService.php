<?php

namespace Modules\Wallet\Services\Requests;

use Illuminate\Support\Facades\DB;

use Modules\Wallet\Classes\DTO\TransactionDTO;
use Modules\Wallet\Classes\DTO\WalletCashOutRequestDTO;
use Modules\Wallet\Classes\Validator\CashOutRequestValidator;
use Modules\Wallet\Enums\TransactionType;
use Modules\Wallet\Enums\WalletCashOutRequestStatusEnum;
use Modules\Wallet\Events\WalletCashOutApprovedEvent;
use Modules\Wallet\Events\WalletCashOutCreateEvent;
use Modules\Wallet\Events\WalletCashOutRequestFailedEvent;
use Modules\Wallet\Events\WalletCashOutRequestRejectEvent;
use Modules\Wallet\Models\WalletCashOutRequest;
use Modules\Wallet\Services\PurchaseService;
use Modules\Wallet\Services\TransactionService;
use Modules\Wallet\Traits\TransactionBuilder;
use Modules\Wallet\Traits\WalletBalanceManager;
use Throwable;
use Illuminate\Support\Facades\Validator;

class CashOutService
{
    use WalletBalanceManager,TransactionBuilder;
    public function __construct(protected TransactionService $transactionService , protected PurchaseService $purchaseService){}

    /**
     * @throws Throwable
     */
    public function create(WalletCashOutRequestDTO $dto): WalletCashOutRequest
    {
        $validator = Validator::make([
            'wallet_id' => $dto->walletId,
            'amount' => $dto->amount,
            'destination_id' => $dto->destinationId
        ], CashOutRequestValidator::rules());

        $validator->validate();
        return DB::transaction(function () use ($dto) {
            $request = WalletCashOutRequest::create([
                'wallet_id' => $dto->walletId,
                'destination_id' => $dto->destinationId,
                'amount' => $dto->amount,
                'meta' => $dto->meta,
                'status' => WalletCashOutRequestStatusEnum::PENDING,
            ]);
            $this->lockAmount($request->wallet,$request->amount);
            event(new WalletCashOutCreateEvent($request));
            return $request;
        });

    }

    /**
     * @throws Throwable
     */
    public function approve(WalletCashOutRequest $request): void
    {
        if (! $request->isPending()) {
            return;
        }

        DB::transaction(function () use ($request) {
            $request->update([
                'status' => WalletCashOutRequestStatusEnum::SUCCESS,
                'verified_at' => now(),
            ]);
            $this->cashOut($request->wallet,$request->amount,'برداشت از کیف پول',$request,$request->meta);

            $request->wallet->decrementBalance($request->amount,'locked_balance');

            event(new WalletCashOutApprovedEvent($request));
        });
    }

    public function failed(WalletCashOutRequest $request, string $reason): WalletCashOutRequest
    {
        if (! $request->isPending()) {
            return $request;
        }
        $request->status = WalletCashOutRequestStatusEnum::FAILED;
        $request->reason = $reason;
        $request->save();

        event(new WalletCashOutRequestFailedEvent($request));
        $this->releaseLockedAmount($request->wallet,$request->amount);
        return $request;
    }

    public function reject(WalletCashOutRequest $request, string $reason): WalletCashOutRequest
    {
        if($request->isPending()) {
            return $request;
        }
        $request->status = WalletCashOutRequestStatusEnum::REJECTED;
        $request->reason = $reason;
        $request->save();

        event(new WalletCashOutRequestRejectEvent($request));
        $this->releaseLockedAmount($request->wallet,$request->amount);
        return $request;
    }
}
