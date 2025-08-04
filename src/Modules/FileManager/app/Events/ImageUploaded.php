<?php

namespace Modules\FileManager\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Modules\FileManager\Models\Image;

class ImageUploaded
{
    use Dispatchable;

    public function __construct(public Image $image)
    {
    }
}
