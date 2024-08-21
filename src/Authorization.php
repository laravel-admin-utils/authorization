<?php

namespace Elegant\Utils\Authorization;

use Elegant\Utils\Extension;

class Authorization extends Extension
{
    public $name = 'authorization';

    public $views = __DIR__ . '/../resources/views';

    public $config = __DIR__ . '/../config';

    public $database = __DIR__ . '/../database';
}
