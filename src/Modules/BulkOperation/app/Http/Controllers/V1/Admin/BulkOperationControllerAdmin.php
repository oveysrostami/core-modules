<?php

namespace Modules\BulkOperation\Http\Controllers\V1\Admin;

use Illuminate\Http\Request;
use Modules\BulkOperation\Classes\DTO\BulkOperationData;
use Modules\BulkOperation\Http\Requests\BulkOperationApproveRequest;
use Modules\BulkOperation\Http\Requests\BulkOperationRequest;
use Modules\BulkOperation\Models\BulkOperation;
use Modules\BulkOperation\Services\BulkOperationService;
use Modules\BulkOperation\Transformers\BulkOperationResource;
use Modules\Core\Http\Controllers\V1\AdminBaseController;
use Modules\Core\Services\CoreQueryBuilder;

class BulkOperationControllerAdmin extends AdminBaseController
{
    public function __construct(protected BulkOperationService $service) {}

    public function index(Request $request)
    {
        $query = CoreQueryBuilder::for(BulkOperation::query(), $request)
            ->allowedFilters([
                'id',
                'file_id',
                'type',
                'status',
                'total',
                'success',
                'failure',
                'created_at',
                'updated_at',
            ])
            ->defaultSort('-created_at');

        return $this->successIndex($query, $request, BulkOperationResource::class);
    }

    public function store(BulkOperationRequest $request)
    {
        $data = new BulkOperationData(...$request->validated());
        $operation = $this->service->create($data);

        return $this->success(new BulkOperationResource($operation));
    }

    public function show(BulkOperation $bulkOperation)
    {
        $operation = $this->service->get($bulkOperation);

        return $this->success(new BulkOperationResource($operation));
    }

    public function approve(BulkOperationApproveRequest $request, BulkOperation $bulkOperation)
    {
        $operation = $this->service->approve($bulkOperation);

        return $this->success(new BulkOperationResource($operation));
    }
}
