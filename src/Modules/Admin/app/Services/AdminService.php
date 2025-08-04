<?php

namespace Modules\Admin\Services;

use Modules\Admin\Classes\DTO\CreateAdminData;
use Modules\Admin\Classes\DTO\UpdateAdminData;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\Models\Admin;

class AdminService
{
    public function create(CreateAdminData $data): Admin
    {
        return Admin::create([
            'first_name' => $data->first_name,
            'last_name' => $data->last_name,
            'email' => $data->email,
            'password' => $data->password ? Hash::make($data->password) : null,
            'is_banned' => $data->is_banned,
        ]);
    }

    public function updateOrCreate(CreateAdminData $data): Admin
    {
        return Admin::updateOrCreate(
            [
                'email' => $data->email,
                'mobile_number' => $data->mobile_number,
            ],
            [
                'first_name' => $data->first_name,
                'last_name' => $data->last_name,
                'password' => $data->password ? Hash::make($data->password) : null,
                'is_banned' => $data->is_banned,
            ]);
    }

    public function update(Admin $admin, UpdateAdminData $data): Admin
    {
        $admin->update(array_filter([
            'first_name' => $data->first_name,
            'last_name' => $data->last_name,
            'password' => $data->password ? Hash::make($data->password) : $admin->password,
            'is_banned' => $data->is_banned,
        ], fn($value) => !is_null($value)));

        return $admin;
    }

    public function delete(Admin $admin): void
    {
        $admin->delete();
    }

    public function get($id): Admin
    {
        return Admin::findOrFail($id);
    }
}
