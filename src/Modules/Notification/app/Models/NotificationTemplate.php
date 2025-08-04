<?php

namespace Modules\Notification\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationTemplate extends Model
{

    /**
     * @property int $id
     * @property string $channel
     * @property string $key
     * @property string $content
     * @property bool $is_active
     */

    protected $casts = [
        'is_active' => 'boolean',
    ];
    protected $fillable = [
        'channel',
        'key',
        'content',
        'is_active'
    ];
}
