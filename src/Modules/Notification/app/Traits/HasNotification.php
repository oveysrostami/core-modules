<?php

namespace Modules\Notification\Traits;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Notification\Models\NotificationLog;

trait HasNotification {
    use HasInternalNotifications;
    public function notifiable(): MorphOne
    {
        return $this->morphOne(NotificationLog::class, 'notifiable','notifiable_type','notifiable_id');
    }
}
