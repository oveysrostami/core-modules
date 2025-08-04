<?php

namespace Modules\Wallet\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentLinkRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'amount' => ['required', 'numeric', 'min:1'],
            'gateway_id' => ['nullable', 'exists:payment_gateways,id'],
        ];

        if ($this->isMethod('POST')) {
            $rules['mobile_number'] = ['required', 'string'];
        }

        return $rules;
    }

    public function authorize(): bool
    {
        return true;
    }
}
