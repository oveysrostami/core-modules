<?php

namespace Modules\Wallet\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Wallet\Enums\WalletPurchaseRequestStatusEnum;
use Modules\Wallet\Traits\HasTransaction;

/**
 * @property int $id
 * @property int $wallet_id
 * @property float $amount
 * @property string $status
 * @property array|null $meta
 * @property string $purchasable_type
 * @property int $purchasable_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WalletPurchaseRequest extends Model
{
    use  HasTransaction, SoftDeletes;

    protected $fillable = [
        'wallet_id',
        'amount',
        'status',
        'meta',
        'purchasable_type',
        'purchasable_id',
    ];

    protected $casts = [
        'meta' => 'array',
        'status' => WalletPurchaseRequestStatusEnum::class,
    ];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function purchasable(): MorphTo
    {
        return $this->morphTo();
    }
    public function cashInRequest(): HasOne
    {
        return $this->hasOne(WalletCashInRequest::class, 'wallet_purchase_request_id');
    }

}
