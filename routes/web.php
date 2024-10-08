<?php

use Illuminate\Support\Facades\Route;

$AuthRoleController = config('elegant-utils.authorization.role.controller', Elegant\Utils\Authorization\Http\Controllers\AuthRoleController::class);
$AuthPermissionController = config('elegant-utils.authorization.permission.controller', Elegant\Utils\Authorization\Http\Controllers\AuthPermissionController::class);

// auth_roles
Route::resource('auth/roles', $AuthRoleController)->names('auth_roles');
Route::put('auth/roles/{role}/restore', $AuthRoleController . '@restore')->name('auth_roles.restore');
Route::delete('auth/roles/{role}/delete', $AuthRoleController . '@delete')->name('auth_roles.delete');

// auth_permissions
Route::resource('auth/permissions', $AuthPermissionController)->names('auth_permissions');
Route::put('auth/permissions/{permission}/restore', $AuthPermissionController . '@restore')->name('auth_permissions.restore');
Route::delete('auth/permissions/{permission}/delete', $AuthPermissionController . '@delete')->name('auth_permissions.delete');