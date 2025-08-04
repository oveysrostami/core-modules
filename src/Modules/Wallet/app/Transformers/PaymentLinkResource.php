<?php

namespace Modules\Wallet\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Core\Transformers\DateTimeResource;

class PaymentLinkResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'mobile_number' => $this->mobile_number,
            'amount' => $this->amount,
            'gateway_id' => $this->gateway_id,
            'token' => $this->token,
            'status' => $this->status,
            'wallet_cash_in_request_id' => $this->wallet_cash_in_request_id,
            'created_at' => DateTimeResource::make($this->created_at),
            'updated_at' => DateTimeResource::make($this->updated_at),
        ];
    }
}
