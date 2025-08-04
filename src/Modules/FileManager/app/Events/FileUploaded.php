<?php

namespace Modules\FileManager\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Modules\FileManager\Models\File;

class FileUploaded
{
    use Dispatchable;

    public function __construct(public File $file)
    {
    }
}
