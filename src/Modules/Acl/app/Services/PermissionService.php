<?php

namespace Modules\Acl\Services;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Modules\Acl\Models\Permission;

class PermissionService
{
    public function create(array $data): Permission
    {
        return Permission::create([
            'name' => $data['name'],
            'label' => $data['label'] ?? null,
        ]);
    }

    public function update(int $id, array $data): Permission
    {
        $permission = $this->find($id);
        $permission->update([
            'name' => $data['name'],
            'label' => $data['label'] ?? $permission->label,
        ]);
        return $permission;
    }

    public function delete(int $id): void
    {
        $permission = $this->find($id);
        $permission->delete();
    }

    public function find(int $id): Permission
    {
        return Permission::findOrFail($id);
    }

    public function findByName(string $name): Permission
    {
        return Permission::where('name', $name)->firstOrFail();
    }

    public function all(array $filters = []): Collection
    {
        $query = Permission::query();

        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        return $query->get();
    }
    public function updateOrCreate(array $attributes, array $values = []): Permission
    {
        return Permission::updateOrCreate($attributes, $values);
    }

    public function syncDependencies(Permission $permission, array $dependencyNames): void
    {
        $permission->dependencies()->delete();

        foreach ($dependencyNames as $dependencyName) {
            $dep = $this->findByName($dependencyName);

            if ($dep->id !== $permission->id && !$permission->wouldCreateCircularDependency($dep)) {

                $permission->dependencies()->create([
                    'depends_on_permission_id' => $dep->id,
                ]);
            }
        }
    }
}
