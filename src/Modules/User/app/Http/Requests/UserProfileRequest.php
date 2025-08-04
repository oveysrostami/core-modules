<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserProfileRequest extends FormRequest
{
    public function rules(): array
    {
        $userId = $this->user()?->id;
        return [
            'first_name' => ['sometimes', 'string', 'max:100'],
            'last_name' => ['sometimes', 'string', 'max:100'],
            'email' => ['sometimes', 'email', 'unique:users,email,' . $userId],
            'mobile_number' => ['sometimes', 'unique:users,mobile_number,' . $userId],
            'password' => ['sometimes', 'string', 'min:8'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
