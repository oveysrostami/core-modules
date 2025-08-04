<?php

namespace Modules\Notification\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class NotificationLog extends Model
{

    /**
     * @property int $id
     * @property string $notifiable_type
     * @property int $notifiable_id
     * @property string $channel
     * @property string $provider
     * @property string $template_key
     * @property array $payload
     * @property string $status
     * @property Carbon|null $sent_at
     * @property string|null $error_message
     */

    protected $casts = [
        'payload' => 'array',
        'sent_at' => 'datetime',
    ];
    protected $guarded = [];

    public function notifiable(): MorphTo
    {
        return $this->morphTo('notifiable', 'notifiable_type', 'notifiable_id');
    }
}
