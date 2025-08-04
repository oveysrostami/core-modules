<?php

namespace Modules\Admin\Http\Controllers\V1\Admin;

use Illuminate\Http\Request;
use Modules\Admin\Classes\DTO\CreateAdminData;
use Modules\Admin\Classes\DTO\UpdateAdminData;
use Modules\Admin\Http\Requests\AdminRequest;
use Modules\Admin\Models\Admin;
use Modules\Admin\Services\AdminService;
use Modules\Admin\Transformers\AdminResource;
use Modules\Core\Http\Controllers\V1\AdminBaseController;
use Modules\Core\Services\CoreQueryBuilder;
use Modules\Core\Traits\ApiResponse;

class AdminControllerAdmin extends AdminBaseController
{
    use ApiResponse;

    public function __construct(protected AdminService $service) {}

    public function index(Request $request)
    {
        $query = CoreQueryBuilder::for(Admin::query(), $request)
            ->allowedFilters([
                'id',
                'first_name',
                'last_name',
                'email',
                'mobile_number',
                'is_banned',
                'last_login_at',
                'created_at',
                'updated_at',
            ])
            ->defaultSort('-created_at');

        return $this->successIndex($query, $request, AdminResource::class);
    }

    public function store(AdminRequest $request)
    {
        $data = new CreateAdminData(...$request->validated());
        $admin = $this->service->create($data);
        return $this->success(new AdminResource($admin));
    }

    public function show(Admin $admin)
    {
        $admin = $this->service->get($admin);
        return $this->success(new AdminResource($admin));
    }

    public function update(AdminRequest $request, Admin $admin)
    {
        $data = new UpdateAdminData(...$request->validated());
        $admin = $this->service->update($admin, $data);
        return $this->success(new AdminResource($admin));
    }

    public function destroy(Admin $admin)
    {
        $this->service->delete($admin);
        return $this->success();
    }

    public function toggleBan(Admin $admin)
    {
        $admin = $this->service->update($admin , new UpdateAdminData(is_banned: !$admin->is_banned));
        return $this->success(new AdminResource($admin));
    }
}
