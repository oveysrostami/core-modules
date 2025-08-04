<?php

namespace Modules\Acl\Http\Controllers\V1\Admin;

use Illuminate\Http\Request;
use Modules\Acl\Classes\DTO\CreateRoleData;
use Modules\Acl\Classes\DTO\UpdateRoleData;
use Modules\Acl\Http\Requests\RoleRequest;
use Modules\Acl\Http\Requests\SyncPermissionsRequest;
use Modules\Acl\Models\Role;
use Modules\Acl\Services\RoleService;
use Modules\Acl\Transformers\PermissionTreeResourceCollection;
use Modules\Acl\Transformers\RoleResource;
use Modules\Core\Http\Controllers\V1\AdminBaseController;
use Modules\Core\Services\CoreQueryBuilder;

class RoleControllerAdmin extends AdminBaseController
{
    public function __construct(protected RoleService $roleService)
    {
    }

    public function index(Request $request)
    {
        $query = CoreQueryBuilder::for(Role::query(), $request)
            ->allowedFilters([
                'id',
                'name',
                'guard_name',
                'created_at',
                'updated_at',
            ])
            ->defaultSort('-created_at');

        return $this->successIndex($query, $request, RoleResource::class);
    }

    public function store(RoleRequest $request)
    {
        $role = $this->roleService->create(CreateRoleData::fromRequest($request));
        return $this->success(RoleResource::make($role));
    }


    public function show(int $id)
    {
        $role = $this->roleService->find($id);
        return $this->success(RoleResource::make($role)->additional(['permission_resource' => PermissionTreeResourceCollection::class]));
    }

    public function update(RoleRequest $request, int $id)
    {
        $role = $this->roleService->update($id, UpdateRoleData::fromRequest($request));
        return $this->success(RoleResource::make($role));
    }

    public function destroy(int $id)
    {
        $this->roleService->delete($id);
        return $this->success(message: 'acl::message.success.role_deleted');
    }

    public function syncPermissions(int $id,SyncPermissionsRequest $request)
    {
        $role = $this->roleService->syncPermissions($id, $request->validated('permissions'));
        return $this->success(new RoleResource($role));
    }
}
