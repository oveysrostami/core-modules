<?php

namespace Modules\Notification\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Notification\Models\InternalNotification;

trait HasInternalNotifications
{
    public function internalNotifications(): MorphMany
    {
        return $this->morphMany(InternalNotification::class, 'notifiable');
    }

    public function notifyInternally(string $type, string $message, array $data = [], ?string $title = null): void
    {
        $this->internalNotifications()->create([
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
        ]);
    }
}
