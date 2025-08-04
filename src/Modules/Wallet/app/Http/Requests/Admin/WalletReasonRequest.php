<?php

namespace Modules\Wallet\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class WalletReasonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reason' => ['nullable', 'string'],
        ];
    }
}
