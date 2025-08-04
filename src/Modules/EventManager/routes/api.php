<?php

use Modules\EventManager\Http\Controllers\V1\Admin\EventLogControllerAdmin;

Route::prefix('admin/v1/event-logs')->name('admin.v1.event-logs.')->middleware(['auth:api','scope:admin'])->group(function () {
    Route::get('/', [EventLogControllerAdmin::class, 'index'])
        ->name('index')
        ->middleware('permission:admin.v1.event-logs.index');

    Route::get('{eventLog}', [EventLogControllerAdmin::class, 'show'])
        ->name('show')
        ->middleware('permission:admin.v1.event-logs.show');

    Route::post('{eventLog}/retry', [EventLogControllerAdmin::class, 'retry'])
        ->name('retry')
        ->middleware('permission:admin.v1.event-logs.retry');
});
