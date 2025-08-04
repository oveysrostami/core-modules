<?php

namespace Modules\Wallet\Services;

use Exception;
use Modules\Core\Exceptions\ApiException;
use Modules\Wallet\Classes\Resolver\PaymentGatewayResolver;
use Modules\Wallet\Enums\WalletCashInRequestStatusEnum;
use Modules\Wallet\Models\WalletCashInRequest;
use Modules\Wallet\Services\Requests\CashInService;
use Shetabit\Payment\Facade\Payment;
use Shetabit\Multipay\Invoice;
use Illuminate\Http\Request;
use Throwable;

class PaymentService
{
    public function __construct(
        protected PaymentGatewayResolver $gatewayResolver,
        protected CashInService $cashInService
    ) {
    }

    /**
     * Create payment link for the given cash in request.
     *
     * @throws ApiException
     * @throws Exception
     */
    public function createPaymentLink(WalletCashInRequest $request, ?string $callbackUrl = null): string
    {
        $request->loadMissing('gateway', 'wallet.walletable');

        if (! $request->gateway) {
            throw new ApiException('gateway.not_found', [], 422, 'wallet');
        }

        $this->gatewayResolver->resolve($request->gateway);

        $invoice = new Invoice();
        $invoice->amount($request->amount);
        $invoice->detail('mobile', $request->wallet->walletable->mobile_number);

        $callbackUrl = $callbackUrl
            ?? config('payment.drivers.' . $request->gateway->driver . '.callbackUrl')
            ?? route('wallet.payment-link.verify', ['token' => $request->id]);

        try {
            return Payment::callbackUrl($callbackUrl)->purchase(
                $invoice,
                function ($driver, $transactionId) use ($request) {
                    $request->update([
                        'transaction_id' => $transactionId,
                        'status' => WalletCashInRequestStatusEnum::PROCESSING,
                    ]);
                }
            )->pay()->toJson();
        } catch (Throwable $e) {
            throw new ApiException('payment.failed', ['message' => $e->getMessage()], 500, 'wallet');
        }
    }

    /**
     * Verify payment for the given request.
     *
     * @throws ApiException
     */
    public function verify(Request $request): WalletCashInRequest
    {
        $purchaseId = $request->input('purchaseId');
        if (! $purchaseId) {
            throw new ApiException('cash_in_request.not_found', [], 404, 'wallet');
        }

        $cashInRequest = WalletCashInRequest::query()->find($purchaseId);
        if (! $cashInRequest) {
            throw new ApiException('cash_in_request.not_found', [], 404, 'wallet');
        }

        if ($cashInRequest->status !== WalletCashInRequestStatusEnum::PROCESSING) {
            throw new ApiException('cash_in_request.not_processing', [], 422, 'wallet');
        }

        $cashInRequest->loadMissing('gateway');

        if (! $cashInRequest->gateway) {
            return $this->cashInService->failed($cashInRequest, 'gateway not found');
        }

        if ($request->input('status') === 'FAILED') {
            if ($request->input('failReason') === 'CANCELLED_BY_USER') {
                return $this->cashInService->canceled($cashInRequest);
            }

            return $this->cashInService->failed($cashInRequest, $request->input('failReason'));
        }

        if ((int) $request->input('amount') !== (int) $cashInRequest->amount) {
            throw new ApiException('payment.amount_mismatch', [], 422, 'wallet');
        }

        $request->merge(['amount' => $cashInRequest->amount]);

        $this->gatewayResolver->resolve($cashInRequest->gateway);

        try {
            $receipt = Payment::amount($cashInRequest->amount)
                ->transactionId($cashInRequest->transaction_id)
                ->verify();

            $cashInRequest->psp_reference_number = $receipt->getReferenceId();

            return $this->cashInService->approve($cashInRequest);
        } catch (Throwable $e) {
            return $this->cashInService->failed($cashInRequest, $e->getMessage());
        }
    }
}
