<?php

namespace Database\Seeders;

use Elegant\Utils\Authorization\Models\Role;
use Elegant\Utils\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AuthorizationTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = date('Y-m-d H:i:s');
        $roles_model = config('elegant-utils.authorization.roles.model');
        $permisssions_model = config('elegant-utils.authorization.permissions.model');

        // create a role.
        $roles_model::query()->truncate();
        $roles_model::query()->create([
            'name' => 'Administrator',
            'slug' => 'administrator',
        ]);

        // add role to user.
        $user_model = config('elegant-utils.authorization.administrator.model');
        $user_model::query()->first()->roles()->save($roles_model::query()->first());

        // add default permissions.
        $permisssions_model::query()->truncate();
        $permisssions_model::query()->insert([
            [
                'menu_id' => 0,
                'name' => 'all',
                'method' => '*',
                'uri' => '*',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 1,
                'name' => 'dashboard',
                'method' => 'GET,HEAD',
                'uri' => '/',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 2,
                'name' => 'list',
                'method' => 'GET,HEAD',
                'uri' => '/auth-users',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 2,
                'name' => 'create',
                'method' => 'GET,HEAD,POST',
                'uri' => '/auth-users/create\r\n/auth-users',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 2,
                'name' => 'edit',
                'method' => 'GET,HEAD,PUT,PATCH',
                'uri' => '/auth-users/{auth-user}/edit\r\n/auth-users/{auth-user}',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 2,
                'name' => 'show',
                'method' => 'GET,HEAD',
                'uri' => '/auth-users/{auth-user}',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 2,
                'name' => 'destroy',
                'method' => 'DELETE',
                'uri' => '/auth-users/{auth-user}',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 2,
                'name' => 'delete',
                'method' => 'DELETE',
                'uri' => '/auth-users/{auth-user}/delete',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 2,
                'name' => 'restore',
                'method' => 'PUT',
                'uri' => '/auth-users/{auth-user}/restore',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 3,
                'name' => 'list',
                'method' => 'GET,HEAD',
                'uri' => '/menus',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 3,
                'name' => 'create',
                'method' => 'POST',
                'uri' => '/menus',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 3,
                'name' => 'edit',
                'method' => 'GET,HEAD,PUT,PATCH',
                'uri' => '/menus/{menu}/edit\r\n/menus/{menu}',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 3,
                'name' => 'destroy',
                'method' => 'DELETE',
                'uri' => '/menus/{menu}',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 3,
                'name' => 'delete',
                'method' => 'DELETE',
                'uri' => '/menus/{menu}/delete',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 3,
                'name' => 'restore',
                'method' => 'PUT',
                'uri' => '/menus/{menu}/restore',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 4,
                'name' => 'list',
                'method' => 'GET,HEAD',
                'uri' => '/roles',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 4,
                'name' => 'create',
                'method' => 'GET,HEAD,POST',
                'uri' => '/roles/create\r\n/roles',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 4,
                'name' => 'edit',
                'method' => 'GET,HEAD,PUT,PATCH',
                'uri' => '/roles/{role}/edit\r\n/roles/{role}',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 4,
                'name' => 'show',
                'method' => 'GET,HEAD',
                'uri' => '/roles/{role}',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 4,
                'name' => 'destroy',
                'method' => 'DELETE',
                'uri' => '/roles/{role}',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 4,
                'name' => 'delete',
                'method' => 'DELETE',
                'uri' => '/roles/{role}/delete',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 4,
                'name' => 'restore',
                'method' => 'PUT',
                'uri' => '/roles/{role}/restore',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 5,
                'name' => 'list',
                'method' => 'GET,HEAD',
                'uri' => '/permissions',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 5,
                'name' => 'create',
                'method' => 'GET,HEAD,POST',
                'uri' => '/permissions/create\r\n/permissions',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 5,
                'name' => 'edit',
                'method' => 'GET,HEAD,PUT,PATCH',
                'uri' => '/permissions/{permission}/edit\r\n/permissions/{permission}',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 5,
                'name' => 'show',
                'method' => 'GET,HEAD',
                'uri' => '/permissions/{permission}',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 5,
                'name' => 'destroy',
                'method' => 'DELETE',
                'uri' => '/permissions/{permission}',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 5,
                'name' => 'delete',
                'method' => 'DELETE',
                'uri' => '/permissions/{permission}/delete',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 5,
                'name' => 'restore',
                'method' => 'PUT',
                'uri' => '/permissions/{permission}/restore',
                'created_at' => $date,
                'updated_at' => $date,
            ],
        ]);

        // add permission to role.
        $roles_model::query()->first()->permissions()->save($permisssions_model::query()->first());

        // add menus.
        Menu::query()->insert([
            [
                'parent_id' => 0,
                'order' => 4,
                'title' => 'Roles',
                'icon' => 'fas fa-user',
                'uri' => '/roles',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'parent_id' => 0,
                'order' => 5,
                'title' => 'Permissions',
                'icon' => 'fas fa-ban',
                'uri' => '/permissions',
                'created_at' => $date,
                'updated_at' => $date,
            ],
        ]);
    }
}
