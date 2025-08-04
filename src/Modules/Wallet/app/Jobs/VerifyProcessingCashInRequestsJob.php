<?php

namespace Modules\Wallet\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Wallet\Enums\WalletCashInRequestStatusEnum;
use Modules\Wallet\Models\WalletCashInRequest;
use Modules\Wallet\Services\PaymentService;
use Illuminate\Http\Request;

class VerifyProcessingCashInRequestsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(PaymentService $paymentService): void
    {
        WalletCashInRequest::query()
            ->where('status', WalletCashInRequestStatusEnum::PROCESSING)
            ->where('updated_at', '<', now()->subMinutes(15))
            ->each(function (WalletCashInRequest $cashInRequest) use ($paymentService) {
                $request = new Request([
                    'purchaseId' => $cashInRequest->id,
                    'amount' => $cashInRequest->amount,
                ]);

                $paymentService->verify($request);
            });
    }
}
