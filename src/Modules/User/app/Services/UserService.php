<?php

namespace Modules\User\Services;

use Illuminate\Support\Facades\Hash;
use Modules\User\Classes\DTO\CreateUserData;
use Modules\User\Classes\DTO\UpdateUserData;
use Modules\User\Events\UserCreatedEvent;
use Modules\User\Models\User;

class UserService
{
    public function create(CreateUserData $data): User
    {
        $user = User::create([
            'first_name' => $data->first_name,
            'last_name' => $data->last_name,
            'email' => $data->email,
            'mobile_number' => $data->mobile_number,
            'password' => $data->password ? Hash::make($data->password) : null,
            'is_banned' => $data->is_banned,
        ]);

        UserCreatedEvent::dispatch($user);

        return $user;
    }

    public function update(User $user, UpdateUserData $data): User
    {
        $user->update(array_filter([
            'first_name' => $data->first_name,
            'last_name' => $data->last_name,
            'email' => $data->email,
            'mobile_number' => $data->mobile_number,
            'password' => $data->password ? Hash::make($data->password) : $user->password,
            'is_banned' => $data->is_banned,
        ], fn($value) => !is_null($value)));

        return $user;
    }

    public function delete(User $user): void
    {
        $user->delete();
    }

    public function get(User $user): User
    {
        return $user;
    }
}
