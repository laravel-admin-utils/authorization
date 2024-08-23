<?php

namespace Elegant\Utils\Authorization;

use Elegant\Utils\Authorization\Http\Controllers\AdministratorController;
use Elegant\Utils\Form;
use Elegant\Utils\Authorization\Http\Middleware\AuthorizationMiddleware;
use Elegant\Utils\Authorization\Models\AuthUser;
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
     * @var array
     */
    protected $middlewareGroups = [];

    /**
     * {@inheritdoc}
     */
    public function boot(Authorization $extension)
    {
        if (! $extension::boot()) {
            return ;
        }

        $this->loadViewsFrom($extension->views, 'admin-authorize-view');

        if ($this->app->runningInConsole()) {
            $this->publishes([$extension->config => config_path('elegant-utils')], 'admin-authorize-config');
            $this->publishes([$extension->database => database_path()], 'admin-authorize-migrations');
        }

        $this->app->booted(function () use ($extension) {
            $extension::routes($extension->routes);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $router = app('router');

        $router->aliasMiddleware('admin.authorize', AuthorizationMiddleware::class);

        $router->middlewareGroup('admin', array_merge($router->getMiddlewareGroups()['admin'], ['admin.authorize']));

        $this->commands($this->commands);

        Form::extend('checkboxGroup', Fields\CheckBoxGroup::class);
        Form::extend('checkboxTree', Fields\CheckBoxTree::class);
    }
}
