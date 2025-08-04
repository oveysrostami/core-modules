<?php

namespace Modules\Wallet\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Wallet\Enums\PaymentLinkStatusEnum;
use Modules\Admin\Models\Admin;

/**
 * @property int $id
 * @property int $user_id
 * @property string $mobile_number
 * @property float $amount
 * @property int|null $gateway_id
 * @property int|null $wallet_cash_in_request_id
 * @property string $token
 * @property string $status
 * @property Carbon|null $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Admin $user
 */
class PaymentLink extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'mobile_number',
        'amount',
        'gateway_id',
        'wallet_cash_in_request_id',
        'token',
        'status',
    ];

    protected $casts = [
        'status' => PaymentLinkStatusEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function gateway(): BelongsTo
    {
        return $this->belongsTo(PaymentGateway::class);
    }

    public function cashInRequest(): BelongsTo
    {
        return $this->belongsTo(WalletCashInRequest::class, 'wallet_cash_in_request_id');
    }
}
