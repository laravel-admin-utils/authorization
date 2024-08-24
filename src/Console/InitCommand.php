<?php

namespace Elegant\Utils\Authorization\Console;

use Elegant\Utils\Authorization\Authorization;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class InitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'authorization:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize admin-authorize';

    /**
     * Install directory.
     *
     * @var string
     */
    protected $directory = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->directory = config('elegant-utils.admin.directory');

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function handle()
    {
        $this->replaceAuthUser();
        
        $this->call('migrate');

        Authorization::importMenus();

        $this->call('db:seed', ['--class' => Database\Seeders\AuthorizationTablesSeeder::class]);
    }

    /**
     * Replace the contents of the AuthUser controller and model
     * @return void
     */
    public function replaceAuthUser()
    {
        // controller
        $controller = $this->directory . '\Controllers\AuthUserController.php';
        $controller_contents = $this->laravel['files']->get($controller);
        $this->laravel['files']->put(
            $controller,
            str_replace('Elegant\Utils\Http\Controllers\AuthUserController', 'Elegant\Utils\Authorization\Http\Controllers\AuthUserController', $controller_contents)
        );

        // model
        $model = app_path('Models\AuthUser.php');
        $model_contents = $this->laravel['files']->get($model);
        $this->laravel['files']->put(
            $model,
            str_replace('Elegant\Utils\Models\AuthUser', 'Elegant\Utils\Authorization\Models\AuthUser', $model_contents)
        );
    }
}
