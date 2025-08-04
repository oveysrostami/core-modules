<?php

namespace Modules\Wallet\Services\Requests;

use Illuminate\Support\Facades\DB;

use Modules\Wallet\Classes\DTO\WalletTransferRequestDTO;
use Modules\Wallet\Classes\Validator\CashTransferRequestValidator;
use Modules\Wallet\Enums\WalletTransferRequestStatusEnum;
use Modules\Wallet\Events\WalletTransferApprovedEvent;
use Modules\Wallet\Events\WalletTransferCreateEvent;
use Modules\Wallet\Events\WalletTransferFailedEvent;
use Modules\Wallet\Events\WalletTransferRejectedEvent;
use Modules\Wallet\Models\WalletTransferRequest;
use Modules\Wallet\Services\TransactionService;
use Modules\Wallet\Traits\TransactionBuilder;
use Modules\Wallet\Traits\WalletBalanceManager;
use Throwable;

use Illuminate\Support\Facades\Validator;

class TransferService
{
    use WalletBalanceManager,TransactionBuilder;
    public function __construct(protected TransactionService $transactionService){}

    /**
     * @throws Throwable
     */
    public function create(WalletTransferRequestDTO $dto): WalletTransferRequest
    {
        $validator = Validator::make([
            'from_wallet_id' => $dto->fromWalletId,
            'to_wallet_id' => $dto->toWalletId,
            'amount' => $dto->amount,
        ], CashTransferRequestValidator::rules());

        $validator->validate();

        return DB::transaction(function () use ($dto) {
            $request = WalletTransferRequest::create([
                'from_wallet_id' => $dto->fromWalletId,
                'to_wallet_id' => $dto->toWalletId,
                'amount' => $dto->amount,
                'status' => WalletTransferRequestStatusEnum::PENDING,
                'meta' => $dto->meta ?? [],
            ]);

            $this->lockAmount($request->fromWallet,$request->amount);

            event(new WalletTransferCreateEvent($request));
            return $request;
        });
    }

    /**
     * @throws Throwable
     */
    public function approve(WalletTransferRequest $request): void
    {
        if (!$request->isPending()) {
            return;
        }

        DB::transaction(function () use ($request) {
            $request->update([
                'status' => WalletTransferRequestStatusEnum::SUCCESS,
                'verified_at' => now(),
            ]);
            $this->cashOut($request->fromWallet,$request->amount,'برداشت از کیف پول بابت انتقال به کیف '.$request->to_wallet_id
                ,$request,$request->meta);
            $this->cashIn($request->toWallet,$request->amount,'واریز به کیف پول از طریف انتقال از کیف '.$request->from_wallet_id,$request,$request->meta);
            $request->fromWallet->decrementBalance($request->amount,'locked_balance');
            $this->applyDeposit($request->toWallet,$request->amount);
            event(new WalletTransferApprovedEvent($request));
        });
    }

    public function failed(WalletTransferRequest $request, string $reason): WalletTransferRequest
    {
        if (!$request->isPending()) {
            return $request;
        }
        $request->update([
            'status' => WalletTransferRequestStatusEnum::FAILED,
            'reason' => $reason,
        ]);
        $this->releaseLockedAmount($request->fromWallet,$request->amount);

        event(new WalletTransferFailedEvent($request));
        return $request;
    }

    public function reject(WalletTransferRequest $request, string $reason): WalletTransferRequest
    {
        if (!$request->isPending()) {
            return $request;
        }
        $request->update([
            'status' => WalletTransferRequestStatusEnum::REJECTED,
            'reason' => $reason,
        ]);
        $this->releaseLockedAmount($request->fromWallet,$request->amount);
        event(new WalletTransferRejectedEvent($request));
        return $request;
    }
}
