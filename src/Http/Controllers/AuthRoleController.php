<?php

namespace Elegant\Utils\Authorization\Http\Controllers;

use Elegant\Utils\Authorization\Models\Permission;
use Elegant\Utils\Facades\Admin;
use Elegant\Utils\Form;
use Elegant\Utils\Http\Controllers\AdminController;
use Elegant\Utils\Models\Menu;
use Elegant\Utils\Show;
use Elegant\Utils\Table;
use Illuminate\Support\Facades\Auth;

class AuthRoleController extends AdminController
{
    /**
     * @return array|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public function title()
    {
        return trans('admin.roles');
    }

    /**
     * @return \Illuminate\Config\Repository|\Illuminate\Foundation\Application|mixed|string|null
     */
    public function model()
    {
        return config('elegant-utils.authorization.role.model');
    }

    /**
     * Make a table builder.
     *
     * @return Table
     */
    public function table()
    {
        $table = new Table(new $this->model());
        $table->model()->orderByDesc('id');

        $table->column('id', 'ID')->sortable();
        $table->column('slug', trans('admin.slug'));
        $table->column('name', trans('admin.name'));
        $table->column('created_at', trans('admin.created_at'));
        $table->column('updated_at', trans('admin.updated_at'));

        $table->actions(function (Table\Displayers\Actions $actions) {
            if ($actions->row->slug == 'administrator') {
                $actions->disableDestroy();
            }
            if ($actions->row->deleted_at) {
                $actions->disableEdit();
                $actions->disableView();
                $actions->disableDestroy();
                $actions->add(new Table\Actions\Restore());
                $actions->add(new Table\Actions\Delete());
            }
        });

        $table->tools(function (Table\Tools $tools) {
            $tools->batch(function (Table\Tools\BatchActions $actions) {
                $actions->disableDelete();
            });
        });

        $table->filter(function(Table\Filter $filter){
            $filter->disableIdFilter();
            $filter->scope('trashed', trans('admin.trashed'))->onlyTrashed();
            $filter->like('slug', trans('admin.slug'));
            $filter->like('name', trans('admin.name'));
        });

        return $table;
    }

    /**
     * Make a show builder.
     *
     * @param $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show($this->model::findOrFail($id));

        $show->field('id', 'ID');
        $show->field('slug', trans('admin.slug'));
        $show->field('name', trans('admin.name'));
        $show->field('created_at', trans('admin.created_at'));
        $show->field('updated_at', trans('admin.updated_at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form()
    {
        $form = new Form(new $this->model());

        $form->row(function (Form\Layout\Row $row) {
            $row->column(6, function (Form\Layout\Column $column) {
                $column->text('name', trans('admin.name'))
                    ->creationRules(['required', "unique:{$this->model}"])
                    ->updateRules(['required', "unique:{$this->model},name,{{id}}"]);
            });
            $row->column(6, function (Form\Layout\Column $column) {
                $column->text('slug', trans('admin.slug'))
                    ->with(function ($value, Form\Field $field) {
                        if ($value == 'administrator') {
                            $field->readonly();
                        }
                    })
                    ->creationRules(['required', "unique:{$this->model}"])
                    ->updateRules(['required', "unique:{$this->model},slug,{{id}}"]);
            });
        });

        $form->row(function (Form\Layout\Row $row) {
            $row->column(4, function (Form\Layout\Column $column) {
                $column->checkboxTree('menus', trans('admin.menus').trans('admin.permissions'))
                    ->options(Admin::menu());
            });
            $row->column(8, function (Form\Layout\Column $column) {
                $permissionModel = config('elegant-utils.authorization.permission.model');
                $column->checkboxGroup('permissions', trans('admin.action').trans('admin.permissions'))
                    ->options($permissionModel::getOptions());
            });
        });

        return $form;
    }
}
