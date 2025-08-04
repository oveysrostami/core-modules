<?php

namespace Modules\Notification\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Notification\Models\InternalNotification;
use Illuminate\Foundation\Auth\User;

class InternalNotificationPolicy
{
    use HandlesAuthorization;

    public function view(User $user, InternalNotification $notification): bool
    {
        return $this->isOwner($user, $notification);
    }

    public function update(User $user, InternalNotification $notification): bool
    {
        return $this->isOwner($user, $notification);
    }

    public function delete(User $user, InternalNotification $notification): bool
    {
        return $this->isOwner($user, $notification);
    }

    private function isOwner(User $user, InternalNotification $notification): bool
    {
        return $notification->notifiable_type === get_class($user)
            && $notification->notifiable_id === $user->getKey();
    }
}
