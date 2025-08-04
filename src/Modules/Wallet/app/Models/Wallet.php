<?php

namespace Modules\Wallet\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Wallet\Models\Currency;


/**
 * @property int $id
 * @property int $currency_id
 * @property Currency $currency
 * @property float $withdrawable_balance
 * @property float $non_withdrawable_balance
 * @property float $locked_balance
 * @property string $walletable_type
 * @property int $walletable_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Wallet extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'currency_id',
        'withdrawable_balance',
        'non_withdrawable_balance',
        'locked_balance',
        'walletable_type',
        'walletable_id',
    ];

    public function walletable(): MorphTo
    {
        return $this->morphTo();
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function cashInRequests(): HasMany
    {
        return $this->hasMany(WalletCashInRequest::class);
    }

    public function cashOutRequests(): HasMany
    {
        return $this->hasMany(WalletCashOutRequest::class);
    }

    public function sentTransfers(): HasMany
    {
        return $this->hasMany(WalletTransferRequest::class, 'from_wallet_id');
    }

    public function receivedTransfers(): HasMany
    {
        return $this->hasMany(WalletTransferRequest::class, 'to_wallet_id');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function purchaseRequests(): HasMany
    {
        return $this->hasMany(WalletPurchaseRequest::class);
    }

    public function incrementBalance(float $amount, bool $isWithdrawable = true , $type = 'withdrawable_balance'): void
    {
        if($type === 'withdrawable_balance') {
            if ($isWithdrawable) {
                $this->increment('withdrawable_balance', $amount);
            } else {
                $this->increment('non_withdrawable_balance', $amount);
            }
        }else{
            $this->increment($type, $amount);
        }
    }

    public function decrementBalance($amount , $type = 'withdrawable_balance'): void
    {
        $this->decrement($type, $amount);
    }
}
