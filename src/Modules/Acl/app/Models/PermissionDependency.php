<?php

namespace Modules\Acl\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PermissionDependency extends Model
{
    protected $table = 'permission_dependencies';
    protected $fillable = ['permission_id', 'depends_on_permission_id'];

    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }

    public function dependsOn(): BelongsTo
    {
        return $this->belongsTo(Permission::class, 'depends_on_permission_id');
    }
}
