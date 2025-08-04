<?php

namespace Modules\Wallet\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Wallet\Models\Currency;

/**
 * @property int $id
 * @property string $name
 * @property string $driver
 * @property string|null $label
 * @property int $currency_id
 * @property Currency $currency
 * @property array|null $config
 * @property bool $is_active
 * @property int $priority
 * @property bool $supports_installment
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class PaymentGateway extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'driver',
        'label',
        'currency_id',
        'config',
        'is_active',
        'priority',
        'supports_installment',
    ];

    protected $casts = [
        'config' => 'array',
        'is_active' => 'boolean',
        'supports_installment' => 'boolean',
        'priority' => 'integer',
    ];

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
}
