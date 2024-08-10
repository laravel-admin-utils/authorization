<?php

namespace Elegant\Utils\Authorization;

use Elegant\Utils\Authorization\Http\Controllers\AdministratorController;
use Elegant\Utils\Form;
use Elegant\Utils\Authorization\Http\Middleware\AuthorizationMiddleware;
use Elegant\Utils\Authorization\Models\Administrator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AuthorizationServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $commands = [
        Console\InitCommand::class,
    ];

    /**
     * {@inheritdoc}
     */
    public function boot(Authorization $extension)
    {
        if (! $extension::boot()) {
            return ;
        }

        $this->app->booted(function () use ($extension) {
            $extension::routes($extension->routes);
        });

        $this->loadViewsFrom($extension->views, 'admin-authorize-view');

        if (file_exists($routes = $extension->routes)) {
            $this->loadRoutesFrom($routes);
        }

        if ($this->app->runningInConsole()) {
            $this->publishes([$extension->database => database_path()], 'admin-authorize-migrations');
            $this->publishes([$extension->config => config_path('elegant-utils')], 'admin-authorize-config');
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        app('router')->aliasMiddleware('admin.authorize', AuthorizationMiddleware::class);

        // 替换配置文件
        config([
            'auth.providers.users.model' => config('elegant-utils.authorization.administrator.model', Administrator::class),
            'elegant-utils.admin.database.administrator_model' => config('elegant-utils.authorization.administrator.model', Administrator::class),
            'elegant-utils.admin.database.administrator_controller' => config('elegant-utils.authorization.administrator.controller', AdministratorController::class),
            'elegant-utils.admin.route.middleware.authorize' => 'admin.authorize',
        ]);

        $this->commands($this->commands);

        Form::extend('checkboxGroup', Fields\CheckBoxGroup::class);
        Form::extend('checkboxTree', Fields\CheckBoxTree::class);
    }
}
