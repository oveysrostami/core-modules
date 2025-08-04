<?php

namespace Modules\Core\Transformers;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Morilog\Jalali\Jalalian;

class DateTimeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        $time = is_numeric($this->resource)
            ? Carbon::createFromTimestamp($this->resource)
            : Carbon::parse($this->resource);
        return [
            'jalali_date' =>  Jalalian::fromCarbon($time)->toArray()['formatted'],
            'gregorian_date'=>$time->toArray()['formatted'],
        ];
    }
}
