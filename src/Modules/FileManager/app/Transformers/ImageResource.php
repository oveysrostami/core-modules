<?php

namespace Modules\FileManager\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'file' => FileResource::make($this->whenLoaded('file')), 
            'width' => $this->width,
            'height' => $this->height,
            'alt' => $this->alt,
            'priority' => $this->priority,
            'src' => $this->src,
        ];
    }
}
