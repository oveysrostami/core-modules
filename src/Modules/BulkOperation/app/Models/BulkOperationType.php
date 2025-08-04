<?php

namespace Modules\BulkOperation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $type
 * @property bool $requires_admin_approval
 */
class BulkOperationType extends Model
{
    protected $fillable = [
        'type',
        'requires_admin_approval',
    ];

    public function operations(): HasMany
    {
        return $this->hasMany(BulkOperation::class, 'type', 'type');
    }
}
