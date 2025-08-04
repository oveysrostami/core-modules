<?php

namespace Modules\BulkOperation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\FileManager\Models\File;

/**
 * @property int $id
 * @property int $file_id
 * @property string $type
 * @property string $status
 * @property array|null $result_summary
 * @property int $total
 * @property int $success
 * @property int $failure
 */
class BulkOperation extends Model
{
    protected $fillable = [
        'file_id',
        'type',
        'status',
        'result_summary',
        'total',
        'success',
        'failure',
    ];

    protected $casts = [
        'result_summary' => 'array',
    ];

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(BulkOperationResult::class);
    }

    public function typeModel(): BelongsTo
    {
        return $this->belongsTo(BulkOperationType::class, 'type', 'type');
    }
}
