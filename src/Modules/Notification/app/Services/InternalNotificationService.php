<?php

namespace Modules\Notification\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Modules\Notification\Classes\DTO\InternalNotificationDTO;
use Modules\Notification\Events\NotificationRequested;
use Modules\Notification\Models\InternalNotification;

class InternalNotificationService
{
    public function listFor(Model $notifiable)
    {
        return $notifiable->internalNotifications()->latest();
    }

    public function markAsRead(InternalNotification $notification): InternalNotification
    {
        if (!$notification->read_at) {
            $notification->update(['read_at' => Carbon::now()]);
        }

        return $notification->fresh();
    }

    public function markAllAsRead(Model $notifiable): void
    {
        $notifiable->internalNotifications()
            ->whereNull('read_at')
            ->update(['read_at' => Carbon::now()]);
    }

    public function delete(InternalNotification $notification): void
    {
        $notification->delete();
    }

    public function create(InternalNotificationDTO $dto): void
    {
        event(new NotificationRequested(
            notifiable: $dto->user,
            channel: 'in_app',
            templateKey: $dto->template,
            variables: $dto->variables,
            meta: $dto->meta
        ));
    }
}
