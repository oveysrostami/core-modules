<?php

namespace Modules\EventManager\Http\Controllers\V1\Admin;

use Illuminate\Http\Request;
use Modules\Core\Exceptions\ApiException;
use Modules\Core\Http\Controllers\V1\AdminBaseController;
use Modules\Core\Services\CoreQueryBuilder;
use Modules\EventManager\Interfaces\LoggableEventPayloadInterface;
use Modules\EventManager\Interfaces\ShouldBeLogged;
use Modules\EventManager\Models\EventLog;
use Modules\EventManager\Transformers\EventLogResource;
use Throwable;

class EventLogControllerAdmin extends AdminBaseController
{
    public function index(Request $request)
    {
        $query = CoreQueryBuilder::for(EventLog::query(), $request)
            ->allowedFilters([
                'id',
                'event_name',
                'status',
                'payload',
                'exception',
                'dispatched_at',
                'processed_at',
                'created_at',
            ])
            ->defaultSort('-created_at');

        return $this->successIndex($query, $request, EventLogResource::class);
    }

    public function show(EventLog $eventLog)
    {
        return $this->success(new EventLogResource($eventLog));
    }

    /**
     * @throws ApiException
     */
    public function retry(EventLog $eventLog)
    {
        if ($eventLog->status !== 'failed') {
            return $this->error('retry.not_failed',[],'400','event');
        }

        $eventClass = $eventLog->event_name;
        $payload = $eventLog->payload;

        if (! class_exists($eventClass)) {
            return $this->error('retry.event_class_not_exist',[],'400','event');
        }

        if (! is_subclass_of($eventClass, LoggableEventPayloadInterface::class)) {
            return $this->error('event قابلیت بازسازی ندارد.');
        }
        try {
            $eventInstance = $eventClass::fromLoggablePayload($payload);
            if ($eventInstance instanceof ShouldBeLogged) {
                $eventInstance->uuid = $eventLog->uuid;
            }
            event($eventInstance);

            $eventLog->update([
                'status' => 'pending',
                'exception' => null,
            ]);

            return $this->success(message: 'eventmanager::message.success.resent');
        } catch (Throwable $e) {
            throw new ApiException('retry.exception',['message'=>$e->getMessage()],500,'event');
        }
    }
}
