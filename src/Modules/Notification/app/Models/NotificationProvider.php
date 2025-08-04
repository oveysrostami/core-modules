<?php

namespace Modules\Notification\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationProvider extends Model
{

    /**
     * @property int $id
     * @property string $channel
     * @property string $name
     * @property array $config
     * @property bool $is_active
     * @property int $weight
     * @property array|null $forced_for_templates
     */

    protected $guarded = [];
    protected $casts = [
        'config' => 'array',
        'is_active' => 'boolean',
        'weight' => 'integer',
        'forced_for_templates' => 'array',
    ];
}
