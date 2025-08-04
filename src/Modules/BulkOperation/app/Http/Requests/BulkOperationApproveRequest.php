<?php

namespace Modules\BulkOperation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulkOperationApproveRequest extends FormRequest
{
    public function rules(): array
    {
        return [];
    }

    public function authorize(): bool
    {
        return true;
    }
}
