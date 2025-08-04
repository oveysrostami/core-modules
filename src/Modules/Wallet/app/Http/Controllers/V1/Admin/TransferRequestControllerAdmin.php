<?php

namespace Modules\Wallet\Http\Controllers\V1\Admin;

use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\V1\AdminBaseController;
use Modules\Core\Services\CoreQueryBuilder;
use Modules\Core\Traits\ApiResponse;
use Modules\Wallet\Http\Requests\Admin\WalletReasonRequest;
use Modules\Wallet\Models\WalletTransferRequest;
use Modules\Wallet\Services\Requests\TransferService;
use Modules\Wallet\Transformers\WalletTransferRequestResource;

class TransferRequestControllerAdmin extends AdminBaseController
{
    use ApiResponse;

    public function __construct(protected TransferService $service){}

    public function index(Request $request)
    {
        $query = CoreQueryBuilder::for(WalletTransferRequest::query(), $request)
            ->allowedFilters([
                'id',
                'from_wallet_id',
                'to_wallet_id',
                'amount',
                'status',
                'reason',
                'verified_at',
                'meta',
                'created_at',
                'updated_at',
            ])
            ->defaultSort('-created_at');

        return $this->successIndex($query, $request, WalletTransferRequestResource::class);
    }

    public function approve(WalletTransferRequest $transferRequest)
    {
        $this->service->approve($transferRequest);
        return $this->success(new WalletTransferRequestResource($transferRequest));
    }

    public function failed(WalletReasonRequest $request, WalletTransferRequest $transferRequest)
    {
        $transferRequest = $this->service->failed($transferRequest, $request->validated('reason'));
        return $this->success(new WalletTransferRequestResource($transferRequest));
    }

    public function reject(WalletReasonRequest $request, WalletTransferRequest $transferRequest)
    {
        $transferRequest = $this->service->reject($transferRequest, $request->validated('reason'));
        return $this->success(new WalletTransferRequestResource($transferRequest));
    }
}
