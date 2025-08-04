<?php

use Illuminate\Support\Facades\Route;
use Modules\Acl\Http\Controllers\V1\Admin\PermissionControllerAdmin;
use Modules\Acl\Http\Controllers\V1\Admin\RoleControllerAdmin;


Route::middleware(['auth:api' , 'scope:admin'])->prefix('/admin/v1/roles')->name('admin.v1.role.')->group(function () {
    Route::get('/', [RoleControllerAdmin::class, 'index'])->middleware('permission:admin.v1.role.index')->name('index');
    Route::post('/', [RoleControllerAdmin::class, 'store'])->middleware('permission:admin.v1.role.store')->name('store');
    Route::get('{role}', [RoleControllerAdmin::class, 'show'])->middleware('permission:admin.v1.role.show')->name('show');
    Route::put('{role}', [RoleControllerAdmin::class, 'update'])->middleware('permission:admin.v1.role.update')->name('update');
    Route::delete('{role}', [RoleControllerAdmin::class, 'destroy'])->middleware('permission:admin.v1.role.destroy')->name('destroy');
});
Route::middleware(['auth:api','scope:admin'])->prefix('/admin/v1/permissions')->name('admin.v1.permission.')->group(function () {
    Route::get('/',[PermissionControllerAdmin::class,'index'])->name('index')->middleware('permission:admin.v1.permission.index');
});
