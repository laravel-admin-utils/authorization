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
        $menus_model = config('elegant-utils.admin.database.menus_model');
        $roles_model = config('elegant-utils.authorization.roles.model');
        $permisssions_model = config('elegant-utils.authorization.permissions.model');
        // add menus.
        $menus_model::query()->insert([
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

        // create a role.
        $roles_model::query()->truncate();
        $roles_model::query()->create([
            'name' => 'Administrator',
            'slug' => 'administrator',
        ]);

        // add role to user.
        $administrator_model = config('elegant-utils.authorization.administrator.model');
        $administrator_model::query()->first()->roles()->save($roles_model::query()->first());

        // add default permissions.
        $permisssions_model::query()->truncate();
        $permisssions_model::query()->insert([
            [
                'menu_id' => 0,
                'name' => 'all',
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
                'http' => '["HEADadministrators"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 2,
                'name' => 'create',
                'http' => '["HEADadministrators/create","POSTadministrators"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 2,
                'name' => 'edit',
                'http' => '["HEADadministrators/{administrator}/edit","PATCHadministrators/{administrator}"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 2,
                'name' => 'show',
                'http' => '["HEADadministrators/{administrator}"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 2,
                'name' => 'destroy',
                'http' => '["DELETEadministrators/{administrator}"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 2,
                'name' => 'delete',
                'http' => '["DELETEadministrators/{administrator}/delete"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 2,
                'name' => 'restore',
                'http' => '["PUTadministrators/{administrator}/restore"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 3,
                'name' => 'list',
                'http' => '["HEADmenus"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 3,
                'name' => 'create',
                'http' => '["POSTmenus"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 3,
                'name' => 'edit',
                'http' => '["HEADmenus/{menu}/edit","PATCHmenus/{menu}"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 3,
                'name' => 'destroy',
                'http' => '["DELETEmenus/{menu}"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 3,
                'name' => 'delete',
                'http' => '["DELETEmenus/{menu}/delete"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 3,
                'name' => 'restore',
                'http' => '["PUTmenus/{menu}/restore"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 4,
                'name' => 'list',
                'http' => '["HEADroles"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 4,
                'name' => 'create',
                'http' => '["HEADroles/create","POSTroles"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 4,
                'name' => 'edit',
                'http' => '["HEADroles/{role}/edit","PATCHroles/{role}"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 4,
                'name' => 'show',
                'http' => '["HEADroles/{role}"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 4,
                'name' => 'destroy',
                'http' => '["DELETEroles/{role}"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 4,
                'name' => 'delete',
                'http' => '["DELETEroles/{role}/delete"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 4,
                'name' => 'restore',
                'http' => '["PUTroles/{role}/restore"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 5,
                'name' => 'list',
                'http' => '["HEADpermissions"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 5,
                'name' => 'create',
                'http' => '["HEADpermissions/create","POSTpermissions"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 5,
                'name' => 'edit',
                'http' => '["HEADpermissions/{permission}/edit","PATCHpermissions/{permission}"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 5,
                'name' => 'show',
                'http' => '["HEADpermissions/{permission}"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 5,
                'name' => 'destroy',
                'http' => '["DELETEpermissions/{permission}"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 5,
                'name' => 'delete',
                'http' => '["DELETEpermissions/{permission}/delete"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'menu_id' => 5,
                'name' => 'restore',
                'http' => '["PUTpermissions/{permission}/restore"]',
                'created_at' => $date,
                'updated_at' => $date,
            ],
        ]);

        // add permission to role.
        $roles_model::query()->first()->permissions()->save($permisssions_model::query()->first());
    }
}
