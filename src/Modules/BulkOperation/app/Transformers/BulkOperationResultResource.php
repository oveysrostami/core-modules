<?php

namespace Modules\BulkOperation\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Core\Transformers\DateTimeResource;

class BulkOperationResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'index' => $this->index,
            'row_data' => $this->row_data,
            'status' => $this->status,
            'message' => $this->message,
            'created_at' => DateTimeResource::make($this->created_at),
        ];
    }
}
