<?php

namespace Modules\Wallet\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Wallet\Enums\WalletCashOutRequestStatusEnum;
use Modules\Wallet\Traits\HasTransaction;

/**
 * @property int $id
 * @property int $wallet_id
 * @property float $amount
 * @property int $destination_id
 * @property string $status
 * @property Carbon|null $verified_at
 * @property array|null $meta
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @method bool isPending()
 * @method bool isFailed()
 * @method bool isSuccess()
 * @method bool isRejected()
 */
class WalletCashOutRequest extends Model
{
    use SoftDeletes, HasTransaction;

    protected $fillable = [
        'wallet_id',
        'amount',
        'destination_id',
        'status',
        'meta',
        'verified_at',
    ];

    protected $casts = [
        'meta' => 'array',
        'verified_at' => 'datetime',
        'status' => WalletCashOutRequestStatusEnum::class,
    ];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(BankAccount::class, 'destination_id');
    }

    public function __call($method, $parameters)
    {
        if (str_starts_with($method, 'is')) {
            $status = strtoupper(substr($method, 2));

            if (! WalletCashOutRequestStatusEnum::tryFrom($status)) {
                throw new \BadMethodCallException("Invalid status method: {$method}");
            }

            return $this->status->value === $status;
        }

        return parent::__call($method, $parameters);
    }
}
