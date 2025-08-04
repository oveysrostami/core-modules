<?php

namespace Modules\Wallet\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Modules\Wallet\Classes\DTO\WalletPurchaseRequestDTO;
use Modules\Wallet\Enums\WalletPurchaseRequestStatusEnum;
use Modules\Wallet\Events\WalletPurchaseApprovedEvent;
use Modules\Wallet\Events\WalletPurchaseCreateEvent;
use Modules\Wallet\Events\WalletPurchaseFailedEvent;
use Modules\Wallet\Events\WalletPurchaseRejectedEvent;
use Modules\Wallet\Models\WalletPurchaseRequest;
use Modules\Wallet\Rules\CompareWithdrawbleAmountAndInputAmount;
use Modules\Wallet\Traits\TransactionBuilder;
use Modules\Wallet\Traits\WalletBalanceManager;
use Throwable;

class PurchaseService
{
    use WalletBalanceManager, TransactionBuilder;

    /**
     * @throws Throwable
     */
    public function create(WalletPurchaseRequestDTO $dto): WalletPurchaseRequest
    {
        $validator = Validator::make([
            'wallet_id' => $dto->walletId,
            'amount' => $dto->amount,
            'purchasable_type' => $dto->purchasableType,
            'purchasable_id' => $dto->purchasableId,
        ], [
            'wallet_id' => ['required', 'exists:wallets,id'],
            'amount' => ['required', 'numeric', new CompareWithdrawbleAmountAndInputAmount()],
            'purchasable_type' => ['required', 'string'],
            'purchasable_id' => ['required', 'integer'],
        ]);

        $validator->validate();

        return DB::transaction(function () use ($dto) {
            $request = WalletPurchaseRequest::create([
                'wallet_id' => $dto->walletId,
                'amount' => $dto->amount,
                'purchasable_type' => $dto->purchasableType,
                'purchasable_id' => $dto->purchasableId,
                'meta' => $dto->meta,
                'status' => WalletPurchaseRequestStatusEnum::PENDING,
            ]);

            $this->lockAmount($request->wallet, $request->amount);

            event(new WalletPurchaseCreateEvent($request));

            return $request;
        });
    }

    /**
     * @throws Throwable
     */
    public function approve(WalletPurchaseRequest $request): void
    {
        if ($request->status !== WalletPurchaseRequestStatusEnum::PENDING) {
            return;
        }

        DB::transaction(function () use ($request) {
            $request->update([
                'status' => WalletPurchaseRequestStatusEnum::SUCCESS,
            ]);

            $this->cashOut($request->wallet, $request->amount, 'برداشت بابت خرید', $request, $request->meta ?? []);
            $request->wallet->decrementBalance($request->amount, 'locked_balance');

            event(new WalletPurchaseApprovedEvent($request));
        });
    }

    public function failed(WalletPurchaseRequest $request, string $reason): WalletPurchaseRequest
    {
        if ($request->status !== WalletPurchaseRequestStatusEnum::PENDING) {
            return $request;
        }

        $request->update([
            'status' => WalletPurchaseRequestStatusEnum::FAILED,
            'meta' => array_merge($request->meta ?? [], ['reason' => $reason]),
        ]);

        $this->releaseLockedAmount($request->wallet, $request->amount);

        event(new WalletPurchaseFailedEvent($request));

        return $request;
    }

    public function reject(WalletPurchaseRequest $request, string $reason): WalletPurchaseRequest
    {
        if ($request->status !== WalletPurchaseRequestStatusEnum::PENDING) {
            return $request;
        }

        $request->update([
            'status' => WalletPurchaseRequestStatusEnum::REJECTED,
            'meta' => array_merge($request->meta ?? [], ['reason' => $reason]),
        ]);

        $this->releaseLockedAmount($request->wallet, $request->amount);

        event(new WalletPurchaseRejectedEvent($request));

        return $request;
    }
}
