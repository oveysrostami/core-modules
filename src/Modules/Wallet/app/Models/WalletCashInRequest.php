<?php

namespace Modules\Wallet\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Wallet\Enums\WalletCashInRequestStatusEnum;
use Modules\Wallet\Traits\HasTransaction;

/**
 * @property int $id
 * @property int $wallet_id
 * @property float $amount
 * @property int|null $gateway_id
 * @property string $status
 * @property string|null $reason
 * @property Carbon|null $verified_at
 * @property bool $is_withdrawable
 * @property string|null $card_number
 * @property string|null $psp_reference_number
 * @property string|null $transaction_id
 * @property array|null $meta
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @method bool isPending()
 * @method bool isFailed()
 * @method bool isSuccess()
 * @method bool isRejected()
 * @method bool isCanceled()
 * @method bool isProcessing()
 */
class WalletCashInRequest extends Model
{

    use SoftDeletes, HasTransaction;

    protected $fillable = [
        'wallet_id',
        'amount',
        'gateway_id',
        'status',
        'reason',
        'verified_at',
        'is_withdrawable',
        'card_number',
        'psp_reference_number',
        'transaction_id',
        'meta',
    ];

    protected $casts = [
        'is_withdrawable' => 'boolean',
        'meta' => 'array',
        'verified_at' => 'datetime',
        'status' => WalletCashInRequestStatusEnum::class,
    ];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function gateway(): BelongsTo
    {
        return $this->belongsTo(PaymentGateway::class, 'gateway_id');
    }
    public function purchaseRequest(): BelongsTo
    {
        return $this->belongsTo(WalletPurchaseRequest::class, 'wallet_purchase_request_id');
    }

    public function __call($method, $parameters)
    {
        if (str_starts_with($method, 'is')) {
            $status = strtoupper(substr($method, 2));

            if (! WalletCashInRequestStatusEnum::tryFrom($status)) {
                throw new \BadMethodCallException("Invalid status method: {$method}");
            }

            return $this->status->value === $status;
        }

        return parent::__call($method, $parameters);
    }
}
