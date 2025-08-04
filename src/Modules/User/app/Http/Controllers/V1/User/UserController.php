<?php

namespace Modules\User\Http\Controllers\V1\User;

use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\V1\UserBaseController;
use Modules\Core\Traits\ApiResponse;
use Modules\User\Classes\DTO\UpdateUserData;
use Modules\User\Http\Requests\UserProfileRequest;
use Modules\User\Services\UserService;
use Modules\User\Transformers\UserResource;

class UserController extends UserBaseController
{
    use ApiResponse;

    public function __construct(protected UserService $service) {}

    public function show(Request $request)
    {
        return $this->success(new UserResource($request->user()));
    }

    public function update(UserProfileRequest $request)
    {
        $user = $request->user();
        $user = $this->service->update($user, new UpdateUserData(...$request->validated()));
        return $this->success(new UserResource($user));
    }
}
