<?php

namespace Modules\Notification\Http\Controllers\V1\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\V1\AdminBaseController;
use Modules\Notification\Models\InternalNotification;
use Modules\Notification\Services\InternalNotificationService;
use Modules\Notification\Transformers\InternalNotificationResource;


class InternalNotificationControllerAdmin extends AdminBaseController
{
    use AuthorizesRequests;
    protected InternalNotificationService $service;

    public function __construct(InternalNotificationService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $notifiable = $request->user();
        $query = $this->service->listFor($notifiable);
        $list = $query->get();
        return $this->success(InternalNotificationResource::collection($list));
    }

    public function markAsRead(InternalNotification $notification)
    {
        $this->authorize('update', $notification);

        $updated = $this->service->markAsRead($notification);

        return $this->success($updated, 'notification::message.success.marked_as_read');
    }

    public function markAllAsRead(Request $request)
    {
        $notifiable = $request->user();
        $this->service->markAllAsRead($notifiable);

        return $this->success([], 'notification::message.success.all_marked_as_read');
    }

    public function destroy(InternalNotification $notification)
    {
        $this->authorize('delete', $notification);

        $this->service->delete($notification);

        return $this->success([], 'notification::message.success.deleted');
    }
}
