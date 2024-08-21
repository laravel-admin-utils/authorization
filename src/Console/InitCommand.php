<?php

namespace Elegant\Utils\Authorization\Console;

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
        $this->directory = config('elegant-utils.admin.directory');

        $this->createAuthRoleController();
        $this->createAuthPermissionController();

        $this->createAuthRoleModel();
        $this->createAuthPermissionModel();

        $this->replaceAuthUser();

        $this->addRoutes();

        $this->initDatabase();
    }

    /**
     * Create AuthRoleController.
     *
     * @return void
     */
    public function createAuthRoleController()
    {
        $controller = $this->directory.'\Controllers\AuthRoleController.php';
        $contents = $this->getStub('AuthRoleController');

        $this->laravel['files']->put(
            $controller,
            str_replace('DummyNamespace', config('elegant-utils.admin.route.namespace'), $contents)
        );
        $this->line('<info>AuthRoleController file was created:</info> '.str_replace(base_path(), '', $controller));
    }

    /**
     * Create AuthPermissionController.
     *
     * @return void
     */
    public function createAuthPermissionController()
    {
        $controller = $this->directory.'\Controllers\AuthPermissionController.php';
        $contents = $this->getStub('AuthPermissionController');

        $this->laravel['files']->put(
            $controller,
            str_replace('DummyNamespace', config('elegant-utils.admin.route.namespace'), $contents)
        );
        $this->line('<info>AuthPermissionController file was created:</info> '.str_replace(base_path(), '', $controller));
    }

    /**
     * Create AuthRoleModel.
     *
     * @return void
     */
    public function createAuthRoleModel()
    {
        $model = app_path('Models\AuthRole.php');
        $contents = $this->getStub('AuthRole');

        $this->laravel['files']->put($model, $contents);
        $this->line('<info>AuthRole file was created:</info> '.str_replace(base_path(), '', $model));
    }

    /**
     * Create AuthPermissionModel.
     *
     * @return void
     */
    public function createAuthPermissionModel()
    {
        $model = app_path('Models\AuthPermission.php');
        $contents = $this->getStub('AuthPermission');

        $this->laravel['files']->put($model, $contents);
        $this->line('<info>AuthPermission file was created:</info> '.str_replace(base_path(), '', $model));
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

    /**
     * Add roles and permission routes
     *
     * @return void
     */
    public function addRoutes()
    {
        // If no role routing exists
        if (!Route::has('auth.roles.index')) {
            $routes = $this->directory . '\routes.php';
            $routes_contents = $this->laravel['files']->get($routes);

            $search = "    });
});";
            $replace = $this->getStub('routes');

            $this->laravel['files']->put($routes, str_replace($search, $replace, $routes_contents));
        }
    }

    /**
     * Create tables and seed it.
     *
     * @return void
     */
    public function initDatabase()
    {
        $this->call('migrate');

        $this->call('db:seed', ['--class' => \Database\Seeders\AuthorizationTablesSeeder::class]);
    }

    /**
     * Get stub contents.
     *
     * @param $name
     *
     * @return string
     */
    protected function getStub($name)
    {
        return $this->laravel['files']->get(__DIR__."/stubs/$name.stub");
    }
}
