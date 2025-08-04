<?php

namespace Modules\Wallet\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Wallet\Enums\TransactionType;

/**
 * @property int $id
 * @property int $wallet_id
 * @property string $type
 * @property string $status
 * @property float $amount
 * @property string|null $description
 * @property string|null $transactionable_type
 * @property int|null $transactionable_id
 * @property bool $is_withdrawable
 * @property array|null $meta
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Transaction extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'wallet_id',
        'type',
        'status',
        'amount',
        'description',
        'transactionable_type',
        'transactionable_id',
        'is_withdrawable',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
        'type' => TransactionType::class,
    ];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function transactionable(): MorphTo
    {
        return $this->morphTo();
    }
}
