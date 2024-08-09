<?php

namespace Elegant\Utils\Authorization\Models;

use Elegant\Utils\Traits\DefaultDatetimeFormat;
use Elegant\Utils\Traits\ModelTree;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory;
    use DefaultDatetimeFormat;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $connection = config('elegant-utils.admin.database.connection');

        $this->setConnection($connection);

        $this->setTable(config('elegant-utils.authorization.roles.table'));

        parent::__construct($attributes);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function administrators(): BelongsToMany
    {
        $userModel = config('elegant-utils.authorization.administrator.model');
        $table = config('elegant-utils.authorization.administrator_role_relational.table');
        $role_id = config('elegant-utils.authorization.administrator_role_relational.role_id');
        $administrator_id = config('elegant-utils.authorization.administrator_role_relational.administrator_id');

        return $this->belongsToMany($userModel, $table, $role_id, $administrator_id)->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        $permissionModel = config('elegant-utils.authorization.permissions.model');
        $table = config('elegant-utils.authorization.role_permission_relational.table');
        $role_id = config('elegant-utils.authorization.role_permission_relational.role_id');
        $permission_id = config('elegant-utils.authorization.role_permission_relational.permission_id');

        return $this->belongsToMany($permissionModel, $table, $role_id, $permission_id)->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function menus(): BelongsToMany
    {
        $menuModel = config('elegant-utils.admin.database.menus_model');
        $table = config('elegant-utils.authorization.role_menu_relational.table');
        $role_id = config('elegant-utils.authorization.role_menu_relational.role_id');
        $menu_id = config('elegant-utils.authorization.role_menu_relational.menu_id');

        return $this->belongsToMany($menuModel, $table, $role_id, $menu_id)->withTimestamps();
    }

    /**
     * Detach models from the relationship.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            if (!method_exists($model, 'trashed') || (method_exists($model, 'trashed') && $model->trashed())) {
                $model->users()->detach();
            }
        });
    }
}
