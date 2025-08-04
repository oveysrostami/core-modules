<?php

namespace Modules\Wallet\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Modules\Wallet\Events\CurrencyCreatedEvent;

/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string|null $symbol
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Currency extends Model
{
    protected $fillable = [
        'name',
        'code',
        'symbol',
    ];

    protected static function booted(): void
    {
        static::created(function (Currency $currency) {
            event(new CurrencyCreatedEvent($currency));
            Cache::forget('wallet.currencies');
        });

        static::updated(fn () => Cache::forget('wallet.currencies'));
        static::deleted(fn () => Cache::forget('wallet.currencies'));
    }

    public function wallets(): HasMany
    {
        return $this->hasMany(Wallet::class);
    }

    public function paymentGateways(): HasMany
    {
        return $this->hasMany(PaymentGateway::class);
    }
}
