<?php

namespace Modules\Wallet\Http\Controllers\V1\Admin;

use Illuminate\Http\Request;
use Modules\Core\Exceptions\ApiException;
use Modules\Core\Http\Controllers\V1\AdminBaseController;
use Modules\Core\Services\CoreQueryBuilder;
use Modules\Wallet\Classes\DTO\CreatePaymentLinkData;
use Modules\Wallet\Classes\DTO\UpdatePaymentLinkData;
use Modules\Wallet\Http\Requests\PaymentLinkRequest;
use Modules\Wallet\Models\PaymentLink;
use Modules\Wallet\Services\PaymentLinkService;
use Modules\Wallet\Transformers\PaymentLinkResource;

class PaymentLinkControllerAdmin extends AdminBaseController
{
    public function __construct(protected PaymentLinkService $service) {}

    public function index(Request $request)
    {
        $query = CoreQueryBuilder::for(PaymentLink::query(), $request)
            ->allowedFilters([
                'id',
                'mobile_number',
                'amount',
                'gateway_id',
                'token',
                'status',
                'wallet_cash_in_request_id',
                'created_at',
                'updated_at',
            ])
            ->defaultSort('-created_at');

        return $this->successIndex($query, $request, PaymentLinkResource::class);
    }

    /**
     * @throws ApiException
     */
    public function store(PaymentLinkRequest $request)
    {
        $data = new CreatePaymentLinkData(...$request->validated());
        $link = $this->service->create($data);
        return $this->success(new PaymentLinkResource($link));
    }

    public function show(PaymentLink $paymentLink)
    {
        $link = $this->service->get($paymentLink);
        return $this->success(new PaymentLinkResource($link));
    }

    public function update(PaymentLinkRequest $request, PaymentLink $paymentLink)
    {
        $data = new UpdatePaymentLinkData(...$request->validated());
        $link = $this->service->update($paymentLink, $data);
        return $this->success(new PaymentLinkResource($link));
    }

    public function destroy(PaymentLink $paymentLink)
    {
        $this->service->delete($paymentLink);
        return $this->success();
    }
}
