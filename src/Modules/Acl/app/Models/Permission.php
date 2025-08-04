<?php

namespace Modules\Acl\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    /**
     * Class Permission
     *
     * @property int $id
     * @property string $name
     * @property string $guard_name
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     */
    protected $fillable = ['name', 'guard_name' , 'label'];

    /**
     * Permissionهایی که این permission برای کار کردن به آن‌ها نیاز دارد.
     */
    public function dependencies(): HasMany
    {
        return $this->hasMany(\Modules\Acl\Models\PermissionDependency::class, 'permission_id');
    }

    /**
     * Permissionهایی که به این permission وابسته هستند.
     */
    public function dependents(): HasMany
    {
        return $this->hasMany(\Modules\Acl\Models\PermissionDependency::class, 'depends_on_permission_id');
    }

    /**
     * بررسی می‌کند که آیا این permission به یک permission خاص وابسته است یا نه.
     */
    public function hasDependency(string $permissionName): bool
    {
        return $this->dependencies()
            ->whereHas('dependsOn', function ($query) use ($permissionName) {
                $query->where('name', $permissionName);
            })
            ->exists();
    }

    /**
     * لیست نام permissionهایی که این permission به آن‌ها وابسته است.
     */
    public function dependencyNames(): array
    {
        return $this->dependencies()
            ->with('dependsOn')
            ->get()
            ->pluck('dependsOn.name')
            ->filter()
            ->toArray();
    }

    /**
     * لیست نام permissionهایی که به این permission وابسته هستند.
     */
    public function dependentNames(): array
    {
        return $this->dependents()
            ->with('permission')
            ->get()
            ->pluck('permission.name')
            ->filter()
            ->toArray();
    }

    /**
     * بررسی می‌کند که آیا اضافه کردن یک permission به‌عنوان وابسته، باعث ایجاد حلقه می‌شود یا نه.
     */
    public function wouldCreateCircularDependency(Permission $target): bool
    {
        return $target->hasDependencyRecursive($this);
    }

    /**
     * بررسی بازگشتی اینکه آیا این permission (یا زیرشاخه‌هایش) به permission خاصی وابسته هستند.
     */
    public function hasDependencyRecursive(Permission $target, array $visited = []): bool
    {
        if (in_array($this->id, $visited)) {
            return false;
        }

        $visited[] = $this->id;
        foreach ($this->dependencies as $dependency) {
            if (!$dependency->dependsOn) {
                continue;
            }

            if ($dependency->dependsOn->id === $target->id) {
                return true;
            }

            if ($dependency->dependsOn->hasDependencyRecursive($target, $visited)) {
                return true;
            }
        }

        return false;
    }
}
