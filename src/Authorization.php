<?php

namespace Elegant\Utils\Authorization;

use Elegant\Utils\Extension;

class Authorization extends Extension
{
    public $name = 'authorization';

    public $views = __DIR__ . '/../resources/views';

    public $routes = __DIR__ . '/../routes/web.php';

    public $database = __DIR__ . '/../database';

    public $config = __DIR__ . '/../config';

    public $menu = [
        'title' => 'Authorization',
        'path' => 'authorization',
        'icon' => 'fa-gears',
    ];
}