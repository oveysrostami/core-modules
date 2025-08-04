<?php

namespace Modules\FileManager\Classes\DTO;

use Illuminate\Http\UploadedFile;

class UploadFileData
{
    public function __construct(
        public UploadedFile $file,
        public string $disk,
        public ?string $path = null,
    ) {
    }
}
