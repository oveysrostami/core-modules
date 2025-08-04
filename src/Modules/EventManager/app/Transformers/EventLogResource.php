<?php

namespace Modules\EventManager\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Core\Transformers\DateTimeResource;

class EventLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'event_name'    => $this->event_name,
            'status'        => $this->status,
            'payload'       => $this->payload,
            'exception'     => $this->exception,
            'dispatched_at' => DateTimeResource::make($this->dispatched_at),
            'processed_at'  => DateTimeResource::make($this->processed_at),
            'created_at'    => DateTimeResource::make($this->created_at),
        ];
    }
}
