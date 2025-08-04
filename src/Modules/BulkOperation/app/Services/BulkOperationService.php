<?php

namespace Modules\BulkOperation\Services;

use Modules\BulkOperation\Classes\DTO\BulkOperationData;
use Modules\BulkOperation\Jobs\ProcessBulkOperationJob;
use Modules\BulkOperation\Models\BulkOperation;
use Modules\BulkOperation\Models\BulkOperationType;
use Modules\Core\Exceptions\ApiException;

class BulkOperationService
{
    public function create(BulkOperationData $data): BulkOperation
    {
        $type = BulkOperationType::where('type', $data->type)->first();
        if (! $type) {
            throw new ApiException('type_not_found', translationNamespace: 'bulkoperation');
        }

        $operation = BulkOperation::create([
            'file_id' => $data->file_id,
            'type' => $data->type,
        ]);

        ProcessBulkOperationJob::dispatch($operation->id, ! $type->requires_admin_approval);

        return $operation;
    }

    public function approve(BulkOperation $operation): BulkOperation
    {
        if ($operation->status !== 'waiting_admin') {
            throw new ApiException('cannot_approve', translationNamespace: 'bulkoperation');
        }

        $operation->update(['status' => 'approved']);

        ProcessBulkOperationJob::dispatch($operation->id, true);

        return $operation;
    }

    public function get(BulkOperation $operation): BulkOperation
    {
        return $operation->load('results');
    }
}
