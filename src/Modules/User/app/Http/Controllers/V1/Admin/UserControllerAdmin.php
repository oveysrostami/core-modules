<?php

namespace Modules\User\Http\Controllers\V1\Admin;

use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\V1\AdminBaseController;
use Modules\Core\Services\CoreQueryBuilder;
use Modules\Core\Traits\ApiResponse;
use Modules\User\Classes\DTO\CreateUserData;
use Modules\User\Classes\DTO\UpdateUserData;
use Modules\User\Http\Requests\UserRequest;
use Modules\User\Models\User;
use Modules\User\Services\UserService;
use Modules\User\Transformers\UserResource;

class UserControllerAdmin extends AdminBaseController
{
    public function __construct(protected UserService $service) {}

    public function index(Request $request)
    {
        $query = CoreQueryBuilder::for(User::query(), $request)
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

        return $this->successIndex($query, $request, UserResource::class);
    }

    public function store(UserRequest $request)
    {
        $data = new CreateUserData(...$request->validated());
        $user = $this->service->create($data);
        return $this->success(new UserResource($user));
    }

    public function show(User $user)
    {
        $user = $this->service->get($user);
        return $this->success(new UserResource($user));
    }

    public function update(UserRequest $request, User $user)
    {
        $data = new UpdateUserData(...$request->validated());
        $user = $this->service->update($user, $data);
        return $this->success(new UserResource($user));
    }

    public function destroy(User $user)
    {
        $this->service->delete($user);
        return $this->success();
    }

    public function toggleBan(User $user)
    {
        $user = $this->service->update($user, new UpdateUserData(is_banned: !$user->is_banned));
        return $this->success(new UserResource($user));
    }
}
