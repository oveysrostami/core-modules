<?php

namespace Modules\FileManager\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * @property int $id
 * @property int $file_id
 * @property int $width
 * @property int $height
 * @property string|null $alt
 * @property int $priority
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property File $file
 */
class Image extends Model
{
    protected $fillable = [
        'file_id',
        'width',
        'height',
        'alt',
        'priority',
    ];

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    public function Src(): Attribute
    {
        return new Attribute(
            get: fn() => $this->file
                ? config('filemanager.cdn_url')."/".$this->file->path."/".$this->file->slug.'.'.$this->file->extension
                : null
        );
    }
}
