<?php

namespace Modules\BulkOperation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulkOperationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file_id' => ['required', 'exists:files,id'],
            'type' => ['required', 'exists:bulk_operation_types,type'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
