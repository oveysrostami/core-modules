<?php

namespace Modules\Wallet\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property string $bank_name
 * @property string $card_number
 * @property string|null $iban
 * @property string|null $account_number
 * @property bool $is_default
 * @property string $bankaccountable_type
 * @property int $bankaccountable_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_name',
        'card_number',
        'iban',
        'account_number',
        'is_default',
        'bankaccountable_type',
        'bankaccountable_id',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function bankaccountable(): MorphTo
    {
        return $this->morphTo();
    }
}
