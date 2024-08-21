<?php

namespace Elegant\Utils\Authorization\Http\Controllers;

use Elegant\Utils\Form;
use Elegant\Utils\Http\Controllers\AdminController;
use Elegant\Utils\Show;
use Elegant\Utils\Table;
use Illuminate\Support\Facades\Route;

class AuthPermissionController extends AdminController
{
    /**
     * @return array|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public function title()
    {
        return trans('admin.permissions');
    }

    /**
     * @return \Illuminate\Config\Repository|\Illuminate\Foundation\Application|mixed|string|null
     */
    public function model()
    {
        return config('elegant-utils.authorization.permission.model');
    }

    /**
     * Make a table builder.
     *
     * @return Table
     */
    protected function table()
    {
        $table = new Table(new $this->model());
        $table->model()->orderByDesc('id');

        $table->column('id', 'ID')->sortable();
        $table->column('menu.title', __('admin.menus'))->display(function($menu) {
            return $menu ?? trans('admin.all');
        });
        $table->column('name', __('admin.name'));
        $table->column('http', __('admin.http_uri'))->display(function ($http) {
            return collect($http)->map(function ($path) {
                return "<span>{$path}</span>";;
            })->implode("<br/>");
        });

        $table->actions(function (Table\Displayers\Actions $actions) {
            if ($actions->getKey() == 1) {
                $actions->disableDestroy();
                $actions->disableEdit();
                $actions->disableView();
            }
        });

        return $table;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show($this->model::findOrFail($id));
;
        $show->field('id', 'ID');
        $show->field('menu_id', __('admin.menus'));
        $show->field('name', __('admin.name'));
        $show->field('http', __('admin.http_uri'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new $this->model());

        $form->select('menu_id', __('admin.menus'))->options($this->getMenuOptions());
        $form->text('name', __('admin.name'));
        $form->multipleSelect('http', __('admin.http_uri'))->options($this->getHttpOptions());

        return $form;
    }

    /**
     * @return array
     */
    protected function getMenuOptions()
    {
        $menuModel = config('elegant-utils.admin.database.menu_model');

        return $menuModel::selectOptions();
    }

    /**
     * @return array
     */
    private function getHttpOptions()
    {
        $data = [];

        foreach (Route::getRoutes() as $route) {
            if (isset($route->getAction()['middleware']) && in_array('admin', $route->getAction()['middleware']) && !in_array($route->getAction()['as'], config('elegant-utils.authorization.excludes'))) {
                $domainAndUri = $route->getDomain().$route->uri();

                $methods = $route->methods();

                $data[end($methods).$domainAndUri] = $route;
            }
        }

        $data = array_keys($data);

        array_unshift($data, '*');

        return array_combine($data, $data);
    }
}
