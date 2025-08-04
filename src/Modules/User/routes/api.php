<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\V1\Admin\UserControllerAdmin;
use Modules\User\Http\Controllers\V1\Auth\UserAuthController;
use Modules\User\Http\Controllers\V1\User\UserController;

Route::prefix('admin/v1/users')->name('admin.v1.user.')
    ->middleware(['auth:api','scope:admin'])->group(function () {
        Route::get('/', [UserControllerAdmin::class, 'index'])->name('index')
            ->middleware('permission:admin.v1.user.index');
        Route::post('/', [UserControllerAdmin::class, 'store'])->name('store')
            ->middleware('permission:admin.v1.user.store');
        Route::get('{user}', [UserControllerAdmin::class, 'show'])->name('show')
            ->middleware('permission:admin.v1.user.show');
        Route::put('{user}', [UserControllerAdmin::class, 'update'])->name('update')
            ->middleware('permission:admin.v1.user.update');
        Route::delete('{user}', [UserControllerAdmin::class, 'destroy'])->name('destroy')
            ->middleware('permission:admin.v1.user.destroy');
        Route::patch('{user}/toggle-ban', [UserControllerAdmin::class, 'toggleBan'])->name('toggle-ban')
            ->middleware('permission:admin.v1.user.toggle-ban');
    });

Route::prefix('v1/users')->name('v1.user.')
    ->middleware(['auth:api','scope:user'])->group(function () {
        Route::get('me', [UserController::class, 'show'])->name('show')
            ->middleware('permission:v1.user.show');
        Route::put('me', [UserController::class, 'update'])->name('update')
            ->middleware('permission:v1.user.update');
    });

Route::prefix('v1')->name('v1.auth.')->group(function () {
    Route::post('login', [UserAuthController::class, 'login'])->name('login');
    Route::middleware(['auth:api','scope:user'])->group(function () {
        Route::post('logout', [UserAuthController::class, 'logout'])->name('logout');
        Route::get('me', [UserAuthController::class, 'me'])->name('me');
    });
});
