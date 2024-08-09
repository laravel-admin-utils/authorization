<?php

use Elegant\Utils\Authorization\Http\Controllers\AdministratorController;
use Elegant\Utils\Authorization\Http\Controllers\RoleController;
use Elegant\Utils\Authorization\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Str;

Route::group([
    'middleware' => config('elegant-utils.admin.route.middleware'),
    'as'         => config('elegant-utils.admin.route.as'),
], function (Router $router) {
    $administratorController = config('elegant-utils.authorization.administrator.controller', AdministratorController::class);
    $router->resource('administrators', $administratorController)->names('administrators');

    $roleController = config('elegant-utils.authorization.roles.controller', RoleController::class);
    $router->resource('roles', $roleController)->names('roles');
    $router->put('roles/{role}/restore', $roleController.'@restore')->name('roles.restore');
    $router->delete('roles/{role}/delete', $roleController.'@delete')->name('roles.delete');

    $permissionController = config('elegant-utils.authorization.permissions.controller', PermissionController::class);
    $router->resource('permissions', $permissionController)->names('permissions');
    $router->put('permissions/{permission}/restore', $permissionController.'@restore')->name('permissions.restore');
    $router->delete('permissions/{permission}/delete', $permissionController.'@delete')->name('permissions.delete');
});
