<?php

namespace Modules\Admin\Console;

use Modules\Acl\Services\RoleService;
use Modules\Admin\Classes\DTO\CreateAdminData;
use Modules\Admin\Services\AdminService;
use Modules\Core\Console\ModuleSetup;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class AdminSetup extends ModuleSetup
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'admin:setup';

    /**
     * The console command description.
     */
    protected $description = 'Command description.';


    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $adminService = new AdminService();
        $admin = $adminService->updateOrCreate(new CreateAdminData(
            first_name: 'Super',
            last_name: 'Admin',
            email: config('admin.email'),
            mobile_number: config('admin.mobile_number'),
            password: config('admin.password'),
        ));
        $role = RoleService::findByName('SuperAdmin');
        $admin->assignRole($role);
    }

    protected function getModuleName(): string
    {
        return 'Admin';
    }
}
