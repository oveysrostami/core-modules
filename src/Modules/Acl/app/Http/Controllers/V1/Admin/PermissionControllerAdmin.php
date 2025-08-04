<?php

namespace Modules\Acl\Http\Controllers\V1\Admin;

use Illuminate\Http\Request;
use Modules\Acl\Models\Permission;
use Modules\Acl\Transformers\PermissionResource;
use Modules\Core\Http\Controllers\V1\AdminBaseController;
use Modules\Core\Services\CoreQueryBuilder;
use Modules\Core\Traits\ApiResponse;

class PermissionControllerAdmin extends AdminBaseController
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CoreQueryBuilder::for(Permission::query(), $request)
            ->allowedFilters([
                'id',
                'name',
                'label',
                'created_at',
                'updated_at',
            ])
            ->defaultSort('-created_at');

        return $this->successIndex($query, $request, PermissionResource::class);
    }
}
