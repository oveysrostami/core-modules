<?php

use Illuminate\Support\Facades\Route;
use Modules\FileManager\Http\Controllers\V1\Admin\FileControllerAdmin;
use Modules\FileManager\Http\Controllers\V1\Admin\ImageControllerAdmin;

Route::middleware(['auth:api', 'scope:admin'])
    ->prefix('/admin/v1/files')
    ->name('admin.v1.file.')
    ->group(function () {
        Route::get('/', [FileControllerAdmin::class, 'index'])->middleware('permission:admin.v1.file.index')->name('index');
        Route::post('/', [FileControllerAdmin::class, 'store'])->middleware('permission:admin.v1.file.store')->name('store');
        Route::get('{file}', [FileControllerAdmin::class, 'show'])->middleware('permission:admin.v1.file.show')->name('show');
        Route::delete('{file}', [FileControllerAdmin::class, 'destroy'])->middleware('permission:admin.v1.file.destroy')->name('destroy');
    });

Route::middleware(['auth:api', 'scope:admin'])
    ->prefix('/admin/v1/images')
    ->name('admin.v1.image.')
    ->group(function () {
        Route::get('/', [ImageControllerAdmin::class, 'index'])->middleware('permission:admin.v1.image.index')->name('index');
        Route::post('/', [ImageControllerAdmin::class, 'store'])->middleware('permission:admin.v1.image.store')->name('store');
        Route::get('{image}', [ImageControllerAdmin::class, 'show'])->middleware('permission:admin.v1.image.show')->name('show');
        Route::delete('{image}', [ImageControllerAdmin::class, 'destroy'])->middleware('permission:admin.v1.image.destroy')->name('destroy');
    });
