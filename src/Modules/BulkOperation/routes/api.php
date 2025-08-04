<?php

use Illuminate\Support\Facades\Route;
use Modules\BulkOperation\Http\Controllers\V1\Admin\BulkOperationControllerAdmin;

Route::prefix('admin/v1/bulk-operations')
    ->name('admin.v1.bulk-operation.')
    ->middleware(['auth:api','scope:admin'])
    ->group(function () {
        Route::get('/', [BulkOperationControllerAdmin::class, 'index'])
            ->name('index')
            ->middleware('permission:admin.v1.bulk-operation.index');
        Route::post('/', [BulkOperationControllerAdmin::class, 'store'])
            ->name('store')
            ->middleware('permission:admin.v1.bulk-operation.store');
        Route::get('{bulkOperation}', [BulkOperationControllerAdmin::class, 'show'])
            ->name('show')
            ->middleware('permission:admin.v1.bulk-operation.show');
        Route::patch('{bulkOperation}/approve', [BulkOperationControllerAdmin::class, 'approve'])
            ->name('approve')
            ->middleware('permission:admin.v1.bulk-operation.approve');
    });
