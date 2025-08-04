<?php

namespace Modules\Acl\Models;

use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role as SpatieRole;





class Role extends SpatieRole
{
    /**
     * Class Role
     *
     * @property int $id
     * @property string $name
     * @property string $guard_name
     * @property string|null $label
     */
    protected $fillable = ['name', 'guard_name' , 'label'];
}
