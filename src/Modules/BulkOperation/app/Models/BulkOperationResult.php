<?php

namespace Modules\BulkOperation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $bulk_operation_id
 * @property int $index
 * @property array $row_data
 * @property string $status
 * @property string|null $message
 */
class BulkOperationResult extends Model
{
    protected $fillable = [
        'bulk_operation_id',
        'index',
        'row_data',
        'status',
        'message',
    ];

    protected $casts = [
        'row_data' => 'array',
    ];

    public function bulkOperation(): BelongsTo
    {
        return $this->belongsTo(BulkOperation::class);
    }
}
