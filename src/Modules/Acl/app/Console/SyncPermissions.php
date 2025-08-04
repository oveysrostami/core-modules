<?php

namespace Modules\Acl\Console;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;

use Modules\Acl\Models\Permission;
use Nwidart\Modules\Facades\Module;
use Modules\Acl\Services\PermissionService;

class SyncPermissions extends Command
{
    protected $signature = 'permissions:sync';
    protected $description = 'Sync all permissions from modules into database with dependencies.';

    protected PermissionService $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        parent::__construct();
        $this->permissionService = $permissionService;
    }

    /**
     * @throws FileNotFoundException
     */
    public function handle(): void
    {
        $this->info("🔄 شروع همگام‌سازی سطح دسترسی‌ها...");

        $allPermissions = [];

        $this->permissionService->updateOrCreate(
            ['name' => 'admin.horizon', 'guard_name' => 'api'],
            ['label' => 'Horizon']
        );

        // مرحله اول: ثبت همه permissionها
        foreach (Module::all() as $module) {
            $configPath = module_path($module->getName(), 'config/permissions.php');

            if (!File::exists($configPath)) {
                continue;
            }

            $tree = File::getRequire($configPath);
            $permissions = $this->flattenPermissions($tree);

            foreach ($permissions as $perm) {
                $permission = $this->permissionService->updateOrCreate(
                    ['name' => $perm['name'], 'guard_name' => 'api'],
                    ['label' => $perm['label']]
                );

                $this->info("✅ ثبت یا به‌روزرسانی: {$perm['name']}");

                // ذخیره برای مرحله دوم
                $allPermissions[] = [
                    'permission' => $permission,
                    'depends_on' => $perm['depends_on']
                ];
            }
        }
        // مرحله دوم: ثبت وابستگی‌ها
        foreach ($allPermissions as $entry) {
            $this->permissionService->syncDependencies($entry['permission'], $entry['depends_on']);
        }

        // مرحله سوم: حذف permissionهایی که دیگر تعریف نشده‌اند
        $existingPermissionNames = Permission::pluck('name')->toArray();
        $definedPermissionNames = collect($allPermissions)->pluck('permission.name')->push('admin.horizon')->toArray();
        $toBeDeleted = array_diff($existingPermissionNames, $definedPermissionNames);

        foreach ($toBeDeleted as $name) {
            $permission = Permission::where('name', $name)->first();

            if (!$permission) {
                $this->warn("⚠️ پیدا نشد برای حذف: {$name}");
                continue;
            }
            $this->permissionService->delete($permission->id);
            $this->warn("🗑 حذف شد: {$name}");
        }

        $this->info("🎉 همگام‌سازی سطح دسترسی‌ها با موفقیت انجام شد.");
    }

    protected function flattenPermissions(array $tree, string $prefix = ''): array
    {
        $result = [];

        foreach ($tree as $key => $value) {
            if (is_array($value) && !array_key_exists('label', $value)) {
                // ادامه پیمایش
                $result = array_merge($result, $this->flattenPermissions($value, $prefix . $key . '.'));
            } else {
                $result[] = [
                    'name' => $prefix . $key,
                    'label' => is_array($value) ? $value['label'] : $value,
                    'depends_on' => is_array($value) ? ($value['depends_on'] ?? []) : [],
                ];
            }
        }

        return $result;
    }
}
