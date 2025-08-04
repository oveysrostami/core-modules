<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\V1\Admin\AdminControllerAdmin;
use Modules\Admin\Http\Controllers\V1\Auth\AdminAuthController;

Route::prefix('admin/v1/admins')->name('admin.v1.admin.')->middleware(['auth:api','scope:admin'])->group(function () {
    Route::get('/', [AdminControllerAdmin::class, 'index'])->name('index')->middleware('permission:admin.v1.admin.index');
    Route::post('/', [AdminControllerAdmin::class, 'store'])->name('store')->middleware('permission:admin.v1.admin.store');
    Route::get('{admin}', [AdminControllerAdmin::class, 'show'])->name('show')->middleware('permission:admin.v1.admin.show');
    Route::put('{admin}', [AdminControllerAdmin::class, 'update'])->name('update')->middleware('permission:admin.v1.admin.update');
    Route::delete('{admin}', [AdminControllerAdmin::class, 'destroy'])->name('destroy')->middleware('permission:admin.v1.admin.destroy');
    Route::patch('{admin}/toggle-ban', [AdminControllerAdmin::class, 'toggleBan'])->name('toggle-ban')->middleware('permission:admin.v1.admin.toggle-ban');
});

Route::prefix('admin/v1')->name('admin.v1.admin.auth.')->group(function () {
    Route::post('login', [AdminAuthController::class, 'login'])->name('login');
    Route::middleware(['auth:api','scope:admin'])->group(function () {
        Route::post('logout', [AdminAuthController::class, 'logout'])->middleware('permission:admin.v1.auth.logout')->name('logout');
        Route::get('me', [AdminAuthController::class, 'me'])->middleware('permission:admin.v1.auth.me')->name('me');
    });
});
