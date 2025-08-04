<?php

namespace Modules\Wallet\Services\Requests;


use Modules\Wallet\Classes\DTO\TransactionDTO;
use Modules\Wallet\Classes\DTO\WalletCashInRequestDTO;
use Modules\Wallet\Enums\WalletCashInRequestStatusEnum;
use Modules\Wallet\Events\WalletCashInApprovedEvent;
use Modules\Wallet\Events\WalletCashInCanceledEvent;
use Modules\Wallet\Events\WalletCashInCreateEvent;
use Modules\Wallet\Events\WalletCashInFailedEvent;
use Modules\Wallet\Events\WalletCashInRejectEvent;
use Modules\Wallet\Models\WalletCashInRequest;
use Carbon\Carbon;
use Modules\Wallet\Services\PurchaseService;
use Modules\Wallet\Services\TransactionService;

use Modules\Wallet\Enums\TransactionType;
use Illuminate\Support\Facades\DB;
use Modules\Wallet\Traits\TransactionBuilder;
use Throwable;

class CashInService
{
    use TransactionBuilder;
    public function __construct(protected TransactionService $transactionService , protected PurchaseService $purchaseService){}

    public function create(WalletCashInRequestDTO $dto): WalletCashInRequest
    {
        $request =  WalletCashInRequest::create([
            'wallet_id' => $dto->walletId,
            'amount' => $dto->amount,
            'gateway_id' => $dto->gatewayId,
            'reason' => $dto->reason,
            'is_withdrawable' => $dto->isWithdrawable,
            'card_number' => $dto->cardNumber,
            'meta' => $dto->meta,
            'status' => WalletCashInRequestStatusEnum::PENDING,
        ]);

        event(new WalletCashInCreateEvent($request));

        return  $request;
    }

    /**
     * @throws Throwable
     */
    public function approve(WalletCashInRequest $request): WalletCashInRequest
    {
        if ($request->isPending()) {
            return $request;
        }

        DB::transaction(function () use ($request) {
            $request->status = WalletCashInRequestStatusEnum::SUCCESS;
            $request->verified_at = Carbon::now();
            $request->save();
            $this->cashIn($request->wallet,$request->amount,$request->reason,$request,$request->meta);

            $request->wallet->incrementBalance($request->amount, $request->is_withdrawable);

            if ($request->wallet_purchase_request_id) {
                $purchase = $request->purchaseRequest;
                $this->purchaseService->approve($purchase);
            }
        });

        event(new WalletCashInApprovedEvent($request));

        return $request;
    }

    public function failed(WalletCashInRequest $request, ?string $reason = null): WalletCashInRequest
    {
        if ($request->isPending()) {
            return $request;
        }

        $request->status = WalletCashInRequestStatusEnum::FAILED;
        $request->reason = $reason;
        $request->save();

        event(new WalletCashInFailedEvent($request));
        return $request;
    }

    public function canceled(WalletCashInRequest $request): WalletCashInRequest
    {
        if ($request->isPending()) {
            return $request;
        }

        $request->status = WalletCashInRequestStatusEnum::CANCELED;
        $request->save();

        event(new WalletCashInCanceledEvent($request));
        return $request;
    }

    public function reject(WalletCashInRequest $request, ?string $reason = null): WalletCashInRequest
    {
        if ($request->isPending()) {
            return $request;
        }

        $request->status = WalletCashInRequestStatusEnum::REJECTED;
        $request->reason = $reason;
        $request->save();

        event(new WalletCashInRejectEvent($request));
        return $request;
    }
}
