<?php

namespace Elegant\Utils\Authorization;

use Elegant\Utils\Extension;

class Authorization extends Extension
{
    public $name = 'authorization';

    public $views = __DIR__ . '/../resources/views';

    public $config = __DIR__ . '/../config';

    public $database = __DIR__ . '/../database';
    
    public $routes = __DIR__ . '/../routes/web.php';

    public $menus = [
        [
            'title' => 'Roles',
            'icon' => 'fas fa-user',
            'uri' => 'auth/roles',
        ],
        [
            'title' => 'Permissions',
            'icon' => 'fas fa-ban',
            'uri' => 'auth/permissions',
        ],
    ];
}
