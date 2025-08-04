<?php

namespace Modules\Wallet\Http\Controllers\V1\Admin;

use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\V1\AdminBaseController;
use Modules\Core\Services\CoreQueryBuilder;
use Modules\Core\Traits\ApiResponse;
use Modules\Wallet\Http\Requests\Admin\WalletReasonRequest;
use Modules\Wallet\Models\WalletCashInRequest;
use Modules\Wallet\Services\Requests\CashInService;
use Modules\Wallet\Transformers\WalletCashInRequestResource;

class CashInRequestControllerAdmin extends AdminBaseController
{
    use ApiResponse;

    public function __construct(protected CashInService $service){}

    public function index(Request $request)
    {
        $query = CoreQueryBuilder::for(WalletCashInRequest::query(), $request)
            ->allowedFilters([
                'id',
                'wallet_id',
                'amount',
                'gateway_id',
                'status',
                'reason',
                'verified_at',
                'is_withdrawable',
                'card_number',
                'meta',
                'created_at',
                'updated_at',
            ])
            ->defaultSort('-created_at');

        return $this->successIndex($query, $request, WalletCashInRequestResource::class);
    }

    public function approve(WalletCashInRequest $cashInRequest)
    {
        $cashInRequest = $this->service->approve($cashInRequest);
        return $this->success(new WalletCashInRequestResource($cashInRequest));
    }

    public function failed(WalletReasonRequest $request, WalletCashInRequest $cashInRequest)
    {
        $cashInRequest = $this->service->failed($cashInRequest, $request->validated('reason'));
        return $this->success(new WalletCashInRequestResource($cashInRequest));
    }

    public function reject(WalletReasonRequest $request, WalletCashInRequest $cashInRequest)
    {
        $cashInRequest = $this->service->reject($cashInRequest, $request->validated('reason'));
        return $this->success(new WalletCashInRequestResource($cashInRequest));
    }

    public function cancel(WalletCashInRequest $cashInRequest)
    {
        $cashInRequest = $this->service->canceled($cashInRequest);
        return $this->success(new WalletCashInRequestResource($cashInRequest));
    }
}
