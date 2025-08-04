<?php

namespace Modules\BulkOperation\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Core\Transformers\DateTimeResource;

class BulkOperationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'file_id' => $this->file_id,
            'type' => $this->type,
            'status' => $this->status,
            'result_summary' => $this->result_summary,
            'total' => $this->total,
            'success' => $this->success,
            'failure' => $this->failure,
            'created_at' => DateTimeResource::make($this->created_at),
            'updated_at' => DateTimeResource::make($this->updated_at),
            'results' => BulkOperationResultResource::collection($this->whenLoaded('results')),
        ];
    }
}
