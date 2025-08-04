<?php

namespace Modules\EventManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class EventLog extends Model
{
    /**
     * @property int $id
     * @property string $uuid
     * @property string $event_name
     * @property string $status
     * @property array $payload
     * @property string|null $exception
     * @property Carbon|null $dispatched_at
     * @property Carbon|null $processed_at
     */
    protected $fillable = [
        'uuid',
        'event_name',
        'status',
        'payload',
        'exception',
        'dispatched_at',
        'processed_at',
    ];

    protected $casts = [
        'payload' => 'array',
        'dispatched_at' => 'datetime',
        'processed_at' => 'datetime',
        'uuid' => 'string',
    ];
}
