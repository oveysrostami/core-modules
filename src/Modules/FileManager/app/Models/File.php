<?php

namespace Modules\FileManager\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * @property int $id
 * @property string $type
 * @property string $mime_type
 * @property string $name
 * @property string $slug
 * @property string $path
 * @property string $extension
 * @property string $size
 * @property string $disk
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Image|null $image
 */
class File extends Model
{
    protected $fillable = [
        'type',
        'mime_type',
        'name',
        'slug',
        'path',
        'extension',
        'size',
        'disk',
    ];

    public function image(): HasOne
    {
        return $this->hasOne(Image::class);
    }

    public function Src(): Attribute
    {
        return new Attribute(
            get: fn() => config('filemanager.cdn_url')."/".$this->path."/".$this->slug.'.'.$this->extension
        );
    }
}
