<?php

namespace Database\Seeders;

use Elegant\Utils\Authorization\Models\Role;
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

        // create a role.
        $roles_model = config('elegant-utils.authorization.role.model');
        $roles_model::query()->truncate();
        $roles_model::query()->create([
            'name' => 'Administrator',
            'slug' => 'administrator',
        ]);

        // add role to user.
        $user_model = config('elegant-utils.admin.database.user_model');
        $user_model::query()->first()->roles()->save($roles_model::query()->first());

        // add default permissions.
        $permisssions_model = config('elegant-utils.authorization.permission.model');
        $permisssions_model::query()->truncate();
        $permisssions_model::query()->insert([
            [
                'menu_id' => 0,
                'name' => trans('admin.all'),
                'http' => '["*"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 1,
                'name' => 'dashboard',
                'http' => '["HEAD/"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 2,
                'name' => 'list',
                'http' => '["HEADauth/users"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 2,
                'name' => 'create',
                'http' => '["HEADauth/users/create","POSTauth/users"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 2,
                'name' => 'edit',
                'http' => '["HEADauth/users/{user}/edit","PATCHauth/users/{user}"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 2,
                'name' => 'show',
                'http' => '["HEADauth/users/{user}"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 2,
                'name' => 'destroy',
                'http' => '["DELETEauth/users/{user}"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 2,
                'name' => 'restore',
                'http' => '["PUTauth/users/{user}/restore"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 2,
                'name' => 'delete',
                'http' => '["DELETEauth/users/{user}/delete"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 3,
                'name' => 'list',
                'http' => '["HEADauth/menus"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 3,
                'name' => 'create',
                'http' => '["POSTauth/menus"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 3,
                'name' => 'edit',
                'http' => '["HEADauth/menus/{menu}/edit","PATCHauth/menus/{menu}"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 3,
                'name' => 'destroy',
                'http' => '["DELETEauth/menus/{menu}"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 3,
                'name' => 'restore',
                'http' => '["PUTauth/menus/{menu}/restore"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 3,
                'name' => 'delete',
                'http' => '["DELETEauth/menus/{menu}/delete"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 4,
                'name' => 'list',
                'http' => '["HEADauth/roles"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 4,
                'name' => 'create',
                'http' => '["HEADauth/roles/create","POSTauth/roles"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 4,
                'name' => 'edit',
                'http' => '["HEADauth/roles/{role}/edit","PATCHauth/roles/{role}"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 4,
                'name' => 'show',
                'http' => '["HEADauth/roles/{role}"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 4,
                'name' => 'destroy',
                'http' => '["DELETEauth/roles/{role}"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 4,
                'name' => 'restore',
                'http' => '["PUTauth/roles/{role}/restore"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 4,
                'name' => 'delete',
                'http' => '["DELETEauth/roles/{role}/delete"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 5,
                'name' => 'list',
                'http' => '["HEADauth/permissions"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 5,
                'name' => 'create',
                'http' => '["HEADauth/permissions/create","POSTauth/permissions"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 5,
                'name' => 'edit',
                'http' => '["HEADauth/permissions/{permission}/edit","PATCHauth/permissions/{permission}"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 5,
                'name' => 'show',
                'http' => '["HEADauth/permissions/{permission}"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 5,
                'name' => 'destroy',
                'http' => '["DELETEauth/permissions/{permission}"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 5,
                'name' => 'restore',
                'http' => '["PUTauth/permissions/{permission}/restore"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 5,
                'name' => 'delete',
                'http' => '["DELETEauth/permissions/{permission}/delete"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
        ]);

        // add permission to role.
        $roles_model::query()->first()->permissions()->save($permisssions_model::query()->first());
    }
}
