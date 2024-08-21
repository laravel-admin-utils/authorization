<?php

return [
    'role' => [
        'table' => 'auth_roles',
        'model' => App\Models\AuthRole::class,
    ],

    'permission' => [
        'table' => 'auth_permissions',
        'model' => App\Models\AuthPermission::class,
    ],

    'user_role_relational' => [
        'table' => 'auth_user_roles',
        'user_id' => 'user_id',
        'role_id' => 'role_id',
    ],

    'user_permission_relational' => [
        'table' => 'auth_user_permissions',
        'user_id' => 'user_id',
        'permission_id' => 'permission_id',
    ],

    'user_menu_relational' => [
        'table' => 'auth_user_menus',
        'user_id' => 'user_id',
        'menu_id' => 'menu_id',
    ],

    'role_permission_relational' => [
        'table' => 'auth_role_permissions',
        'role_id' => 'role_id',
        'permission_id' => 'permission_id',
    ],
    
    'role_menu_relational' => [
        'table' => 'auth_role_menus',
        'role_id' => 'role_id',
        'menu_id' => 'menu_id',
    ],

    // Limit the maximum number of administrator roles that can be selected, default is 0, 0 means no limit
//    'user_maximum_roles' => 0,

    // The name of the route to be excluded
    'excepts' => [
        'logout',
        'setting',
        'setting.update',
        'handle_form',
        'handle_action',
        'handle_selectable',
        'handle_renderable',
        'require_config',
        'error404',
    ]
];
