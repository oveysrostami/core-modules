<?php

namespace Modules\Acl\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'unique:roles,name', 'string', 'max:255'],
            'label' => ['required', 'string', 'max:255'],
            'guard_name' => ['sometimes', 'string', 'max:255','in:web,api'],
            'permissions' => ['sometimes', 'array'],
            'permissions.*' => ['exists:permissions,name'],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'name' => __('core::attributes.name'),
            'label' => __('core::attributes.label'),
            'guard_name' => __('core::attributes.guard_name'),
            'permissions' => __('core::attributes.permissions'),
        ];
    }
}
