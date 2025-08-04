<?php

namespace Modules\Acl\Console;

use Illuminate\Console\Command;
use Modules\Acl\Classes\DTO\CreateRoleData;
use Modules\Acl\Models\Permission;
use Modules\Acl\Services\RoleService;

class SyncRoles extends Command
{
    protected $signature = 'roles:sync';
    protected $description = 'Create or update the SuperAdmin role and assign all permissions to it';

    public function handle(): void
    {
        $this->info('🔐 در حال بررسی یا ایجاد نقش SuperAdmin ...');
        $roleService = app(RoleService::class);
        $adminPermissions = Permission::where('guard_name','api')->whereLike('name','admin.%')->pluck('name')->toArray();
        $userPermissions = Permission::where('guard_name','api')->whereLike('name','user.%')->pluck('name')->toArray();
        $roleService->updateOrCreate(new CreateRoleData('user','کاربر','api',$userPermissions));
        $this->info("✅ نقش user با " . count($userPermissions) . " سطح دسترسی همگام‌سازی شد.");
        $roleService->updateOrCreate(new CreateRoleData('SuperAdmin','مدیر کل','api',$adminPermissions));
        $this->info("✅ نقش SuperAdmin با " . count($adminPermissions) . " سطح دسترسی همگام‌سازی شد.");
    }
}
