<?php

use Elegant\Utils\Authorization\Http\Controllers\AdministratorController;
use Elegant\Utils\Authorization\Http\Controllers\RoleController;
use Elegant\Utils\Authorization\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Route;

$administratorController = config('elegant-utils.authorization.administrator.controller', AdministratorController::class);
Route::resource('administrators', $administratorController)->names('administrators');

$roleController = config('elegant-utils.authorization.roles.controller', RoleController::class);
Route::resource('roles', $roleController)->names('roles');
Route::put('roles/{role}/restore', $roleController.'@restore')->name('roles.restore');
Route::delete('roles/{role}/delete', $roleController.'@delete')->name('roles.delete');

$permissionController = config('elegant-utils.authorization.permissions.controller', PermissionController::class);
Route::resource('permissions', $permissionController)->names('permissions');
Route::put('permissions/{permission}/restore', $permissionController.'@restore')->name('permissions.restore');
Route::delete('permissions/{permission}/delete', $permissionController.'@delete')->name('permissions.delete');
