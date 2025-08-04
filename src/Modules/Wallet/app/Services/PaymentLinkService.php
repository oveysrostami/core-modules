<?php

namespace Modules\Wallet\Services;

use Modules\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Core\Exceptions\ApiException;
use Modules\Wallet\Classes\DTO\CreatePaymentLinkData;
use Modules\Wallet\Classes\DTO\UpdatePaymentLinkData;
use Modules\Wallet\Classes\DTO\WalletCashInRequestDTO;
use Modules\Wallet\Enums\PaymentLinkStatusEnum;
use Modules\Wallet\Models\PaymentLink;
use Modules\Wallet\Models\PaymentGateway;
use Modules\Wallet\Models\Wallet;
use Modules\Wallet\Services\Requests\CashInService;
use Modules\Wallet\Services\CurrencyService;

class PaymentLinkService
{
    public function __construct(
        protected CashInService $cashInService,
        protected PaymentService $paymentService,
        protected CurrencyService $currencyService
    ) {
    }

    /**
     * @throws ApiException
     */
    public function create(CreatePaymentLinkData $data): PaymentLink
    {
        $user = User::firstOrCreate(
            ['mobile_number' => $data->mobile_number],
            ['mobile_number' => $data->mobile_number]
        );

        Wallet::firstOrCreate(
            ['walletable_type' => User::class, 'walletable_id' => $user->id],
            [
                'currency_id' => $this->currencyService->getByCode('IRR')->id,
                'withdrawable_balance' => 0,
                'non_withdrawable_balance' => 0,
                'locked_balance' => 0,
            ]
        );

        $gatewayId = $data->gateway_id;

        if (! $gatewayId) {
            $gatewayId = PaymentGateway::query()->where('is_active', true)->value('id');
            if (! $gatewayId) {
                throw new ApiException('gateway.not_found', [], 422, 'wallet');
            }
        }

        return PaymentLink::create([
            'user_id' => $user->id,
            'mobile_number' => $data->mobile_number,
            'amount' => $data->amount,
            'gateway_id' => $gatewayId,
            'token' => Str::uuid()->toString(),
            'status' => PaymentLinkStatusEnum::PENDING,
        ]);
    }

    /**
     * @throws ApiException
     */
    public function update(PaymentLink $link, UpdatePaymentLinkData $data): PaymentLink
    {
        if ($link->status !== PaymentLinkStatusEnum::PENDING) {
            throw new ApiException('payment_link.only_pending_update', [], 422, 'wallet');
        }

        $link->update(array_filter([
            'amount' => $data->amount,
            'gateway_id' => $data->gateway_id,
        ], fn ($value) => !is_null($value)));

        return $link;
    }

    /**
     * @throws ApiException
     */
    public function delete(PaymentLink $link): void
    {
        if ($link->status !== PaymentLinkStatusEnum::PENDING) {
            throw new ApiException('payment_link.only_pending_delete', [], 422, 'wallet');
        }

        $link->delete();
    }

    public function get(PaymentLink $link): PaymentLink
    {
        return $link;
    }

    /**
     * @throws ApiException
     */
    public function open(PaymentLink $link): string
    {
        if ($link->status === PaymentLinkStatusEnum::SUCCESS->value) {
            throw new ApiException('payment_link.already_paid', [], 422, 'wallet');
        }

        if ($link->status === PaymentLinkStatusEnum::PROCESSING->value) {
            $elapsed = now()->diffInMinutes($link->updated_at);
            $remaining = max(0, 15 - $elapsed);
            throw new ApiException('payment_link.processing', ['minutes' => $remaining], 422, 'wallet');
        }

        if (! $link->cashInRequest) {
            $wallet = Wallet::firstOrCreate(
                ['walletable_type' => User::class, 'walletable_id' => $link->user_id],
                [
                    'currency_id' => $this->currencyService->getByCode('IRR')->id,
                    'withdrawable_balance' => 0,
                    'non_withdrawable_balance' => 0,
                    'locked_balance' => 0,
                ]
            );

            $cashInRequest = $this->cashInService->create(
                new WalletCashInRequestDTO(
                    walletId: $wallet->id,
                    amount: $link->amount,
                    gatewayId: $link->gateway_id,
                    isWithdrawable: true
                )
            );

            $link->wallet_cash_in_request_id = $cashInRequest->id;
            $link->status = PaymentLinkStatusEnum::PROCESSING;
            $link->save();
        } else {
            $cashInRequest = $link->cashInRequest;
        }

        $callbackUrl = route('wallet.payment-link.verify', ['token' => $link->token]);
        $paymentData = $this->paymentService->createPaymentLink($cashInRequest, $callbackUrl);
        $data = json_decode($paymentData, true);
        $url = data_get($data, 'url') ?? data_get($data, 'action');

        return (string) $url;
    }

    public function verify(PaymentLink $link, Request $request): PaymentLink
    {
        $cashInRequest = $this->paymentService->verify($request);

        if ($link->wallet_cash_in_request_id === $cashInRequest->id) {
            $link->status = $cashInRequest->status;
            $link->save();
        }

        return $link;
    }
}
