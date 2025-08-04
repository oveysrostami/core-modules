<?php

namespace Modules\FileManager\Classes\DTO;

use Illuminate\Http\UploadedFile;

class UploadImageData
{
    public function __construct(
        public UploadedFile $file,
        public string $disk,
        public ?string $path = null,
        public ?int $width = null,
        public ?int $height = null,
        public ?int $quality = null,
        public ?string $alt = null,
        public ?int $priority = 1,
    ) {
    }
}
