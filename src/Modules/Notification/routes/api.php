<?php

use Illuminate\Support\Facades\Route;
use Modules\Notification\Http\Controllers\V1\Admin\InternalNotificationControllerAdmin;
use Modules\Notification\Http\Controllers\V1\User\InternalNotificationControllerUser;

Route::prefix('admin/v1/internal-notifications')
    ->middleware(['auth:api','scope:admin'])
    ->name('admin.v1.internal-notifications.')
    ->group(function () {
        Route::get('/', [InternalNotificationControllerAdmin::class, 'index'])
            ->name('index')
            ->middleware('permission:admin.v1.internal-notification.index');

        Route::patch('{notification}/read', [InternalNotificationControllerAdmin::class, 'markAsRead'])
            ->name('markAsRead')
            ->middleware('permission:admin.v1.internal-notification.markAsRead');

        Route::patch('read-all', [InternalNotificationControllerAdmin::class, 'markAllAsRead'])
            ->name('markAllAsRead')
            ->middleware('permission:admin.v1.internal-notification.markAllAsRead');

        Route::delete('{notification}', [InternalNotificationControllerAdmin::class, 'destroy'])
            ->name('destroy')
            ->middleware('permission:admin.v1.internal-notification.destroy');
    });

Route::prefix('v1/internal-notifications')
    ->middleware(['auth:api','scope:user'])
    ->name('v1.internal-notifications.')
    ->group(function () {
        Route::get('/', [InternalNotificationControllerUser::class, 'index'])
            ->name('index')
            ->middleware('permission:v1.internal-notification.index');

        Route::patch('{notification}/read', [InternalNotificationControllerUser::class, 'markAsRead'])
            ->name('markAsRead')
            ->middleware('permission:v1.internal-notification.markAsRead');

        Route::patch('read-all', [InternalNotificationControllerUser::class, 'markAllAsRead'])
            ->name('markAllAsRead')
            ->middleware('permission:v1.internal-notification.markAllAsRead');

        Route::delete('{notification}', [InternalNotificationControllerUser::class, 'destroy'])
            ->name('destroy')
            ->middleware('permission:v1.internal-notification.destroy');
    });
