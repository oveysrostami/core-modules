<?php

namespace Modules\Notification\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Core\Transformers\DateTimeResource;

class InternalNotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'title' => $this->title,
            'message' => $this->message,
            'data' => $this->data,
            'read_at' => DateTimeResource::make($this->read_at),
            'created_at' => DateTimeResource::make($this->created_at),
        ];
    }
}
