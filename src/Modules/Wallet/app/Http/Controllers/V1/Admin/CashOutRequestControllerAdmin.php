<?php

namespace Modules\Wallet\Http\Controllers\V1\Admin;

use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\V1\AdminBaseController;
use Modules\Core\Services\CoreQueryBuilder;
use Modules\Core\Traits\ApiResponse;
use Modules\Wallet\Http\Requests\Admin\WalletReasonRequest;
use Modules\Wallet\Models\WalletCashOutRequest;
use Modules\Wallet\Services\Requests\CashOutService;
use Modules\Wallet\Transformers\WalletCashOutRequestResource;

class CashOutRequestControllerAdmin extends AdminBaseController
{
    use ApiResponse;

    public function __construct(protected CashOutService $service){}

    public function index(Request $request)
    {
        $query = CoreQueryBuilder::for(WalletCashOutRequest::query(), $request)
            ->allowedFilters([
                'id',
                'wallet_id',
                'destination_id',
                'amount',
                'status',
                'reason',
                'verified_at',
                'meta',
                'created_at',
                'updated_at',
            ])
            ->defaultSort('-created_at');

        return $this->successIndex($query, $request, WalletCashOutRequestResource::class);
    }

    public function approve(WalletCashOutRequest $cashOutRequest)
    {
        $this->service->approve($cashOutRequest);
        return $this->success(new WalletCashOutRequestResource($cashOutRequest));
    }

    public function failed(WalletReasonRequest $request, WalletCashOutRequest $cashOutRequest)
    {
        $cashOutRequest = $this->service->failed($cashOutRequest, $request->validated('reason'));
        return $this->success(new WalletCashOutRequestResource($cashOutRequest));
    }

    public function reject(WalletReasonRequest $request, WalletCashOutRequest $cashOutRequest)
    {
        $cashOutRequest = $this->service->reject($cashOutRequest, $request->validated('reason'));
        return $this->success(new WalletCashOutRequestResource($cashOutRequest));
    }
}
