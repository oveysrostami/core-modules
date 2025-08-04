<?php

namespace Modules\Wallet\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Wallet\Enums\WalletTransferRequestStatusEnum;
use Modules\Wallet\Traits\HasTransaction;

/**
 * @property int $id
 * @property int $from_wallet_id
 * @property int $to_wallet_id
 * @property float $amount
 * @property string $status
 * @property array|null $meta
 * @property \Carbon\Carbon|null $verified_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method bool isPending()
 * @method bool isFailed()
 * @method bool isSuccess()
 * @method bool isRejected()
 */
class WalletTransferRequest extends Model
{
    use  SoftDeletes, HasTransaction;

    protected $fillable = [
        'from_wallet_id',
        'to_wallet_id',
        'amount',
        'status',
        'meta',
        'verified_at',
    ];

    protected $casts = [
        'meta' => 'array',
        'verified_at' => 'datetime',
        'status' => WalletTransferRequestStatusEnum::class,
    ];

    public function fromWallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'from_wallet_id');
    }

    public function toWallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'to_wallet_id');
    }
    public function __call($method, $parameters)
    {
        if (str_starts_with($method, 'is')) {
            $status = strtoupper(substr($method, 2));

            if (! WalletTransferRequestStatusEnum::tryFrom($status)) {
                throw new \BadMethodCallException("Invalid status method: {$method}");
            }

            return $this->status->value === $status;
        }

        return parent::__call($method, $parameters);
    }
}
