<?php

namespace Modules\Wallet\Http\Controllers\V1\Admin;

use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\V1\AdminBaseController;
use Modules\Core\Services\CoreQueryBuilder;
use Modules\Core\Traits\ApiResponse;
use Modules\Wallet\Http\Requests\Admin\WalletReasonRequest;
use Modules\Wallet\Models\WalletPurchaseRequest;
use Modules\Wallet\Services\PurchaseService;
use Modules\Wallet\Transformers\WalletPurchaseRequestResource;

class PurchaseRequestControllerAdmin extends AdminBaseController
{
    use ApiResponse;

    public function __construct(protected PurchaseService $service){}

    public function index(Request $request)
    {
        $query = CoreQueryBuilder::for(WalletPurchaseRequest::query(), $request)
            ->allowedFilters([
                'id',
                'wallet_id',
                'amount',
                'purchasable_type',
                'purchasable_id',
                'status',
                'meta',
                'created_at',
                'updated_at',
            ])
            ->defaultSort('-created_at');

        return $this->successIndex($query, $request, WalletPurchaseRequestResource::class);
    }

    public function approve(WalletPurchaseRequest $purchaseRequest)
    {
        $this->service->approve($purchaseRequest);
        return $this->success(new WalletPurchaseRequestResource($purchaseRequest));
    }

    public function failed(WalletReasonRequest $request, WalletPurchaseRequest $purchaseRequest)
    {
        $purchaseRequest = $this->service->failed($purchaseRequest, $request->validated('reason'));
        return $this->success(new WalletPurchaseRequestResource($purchaseRequest));
    }

    public function reject(WalletReasonRequest $request, WalletPurchaseRequest $purchaseRequest)
    {
        $purchaseRequest = $this->service->reject($purchaseRequest, $request->validated('reason'));
        return $this->success(new WalletPurchaseRequestResource($purchaseRequest));
    }
}
