<?php

namespace Elegant\Utils\Authorization\Http\Controllers;

use Elegant\Utils\Form;
use Elegant\Utils\Http\Controllers\AdminController;
use Elegant\Utils\Show;
use Elegant\Utils\Table;
use Illuminate\Support\Facades\Route;

class PermissionController extends AdminController
{
    /**
     * @return array|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public function title()
    {
        return trans('admin.permissions');
    }

    public function model()
    {
        return config('elegant-utils.authorization.permissions.model');
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
        $table->column('menu.title', __('admin.menus'));
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
        $menuModel = config('elegant-utils.admin.database.menus_model');

        $form = new Form(new $this->model());

        $form->select('menu_id', __('admin.menus'))->options($menuModel::selectOptions());
        $form->text('name', __('admin.name'));
        $form->multipleSelect('http', __('admin.http_uri'))->options($this->getHttpOptions());

        return $form;
    }

    private function getHttpOptions()
    {
        $data = [];

        foreach (Route::getRoutes() as $route) {
            if (!empty($route->getAction('as')) && substr($route->getAction('as'), 0,6) === config('elegant-utils.admin.route.as')) {
                $domainAndUri = $route->getDomain().$route->uri();

                $methods = $route->methods();

                $data[end($methods).$domainAndUri] = $route;
            }
        }

        $data = array_keys($data);

        return array_combine($data, $data);
    }
}
