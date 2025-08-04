<?php

namespace Modules\Acl\Services;

use Modules\Acl\Classes\DTO\CreateRoleData;
use Modules\Acl\Classes\DTO\UpdateRoleData;
use Modules\Acl\Models\Role;

class RoleService
{
    static public function create(CreateRoleData $roleData): Role
    {
        $role = Role::create(['name' => $roleData->name, 'label' => $roleData->label, 'guard_name' => $roleData->guard_name]);
        if (!empty($roleData->permissions)) {
            $role->syncPermissions($roleData->permissions);
        }

        return $role->fresh(['permissions']);
    }

    static public function updateOrCreate(CreateRoleData $roleData): Role
    {
        $role = Role::updateOrCreate(['name' => $roleData->name, 'guard_name' => $roleData->guard_name], ['label' => $roleData->label]);
        if (!empty($roleData->permissions)) {
            $role->syncPermissions($roleData->permissions);
        }

        return $role->fresh(['permissions']);
    }

    static public function find(int $id): Role
    {
        return Role::with('permissions')->findOrFail($id);
    }

    static public function findByName(string $name): Role
    {
        return Role::with('permissions')->where('name', $name)->firstOrFail();
    }

    public function update(int $id, UpdateRoleData $roleData): Role
    {
        $role = $this->find($id);
        $role->update(['name' => $roleData->name, 'label' => $roleData->label]);

        if (!empty($roleData->permissions)) {
            $role->syncPermissions($roleData->permissions);
        }

        return $role->fresh(['permissions']);
    }

    public function delete(int $id): void
    {
        $role = $this->find($id);
        $role->delete();
    }

    public function syncPermissions(int $id, array $permissions): Role
    {
        $role = $this->find($id);
        $role->syncPermissions($permissions);
        return $role->fresh(['permissions']);
    }
}
