<?php

namespace Modules\Wallet\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Core\Transformers\DateTimeResource;

class WalletCashInRequestResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'wallet_id' => $this->wallet_id,
            'amount' => $this->amount,
            'gateway_id' => $this->gateway_id,
            'status' => $this->status,
            'reason' => $this->reason,
            'verified_at' => DateTimeResource::make($this->verified_at),
            'is_withdrawable' => $this->is_withdrawable,
            'card_number' => $this->card_number,
            'meta' => $this->meta,
            'created_at' => DateTimeResource::make($this->created_at),
            'updated_at' => DateTimeResource::make($this->updated_at),
        ];
    }
}
