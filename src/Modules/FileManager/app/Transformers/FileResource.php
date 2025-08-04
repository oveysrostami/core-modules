<?php

namespace Modules\FileManager\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'mime_type' => $this->mime_type,
            'name' => $this->name,
            'slug' => $this->slug,
            'path' => $this->path,
            'extension' => $this->extension,
            'size' => $this->size,
            'src' => $this->src,
        ];
    }
}
