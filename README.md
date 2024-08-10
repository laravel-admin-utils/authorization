# authorization utils for laravel-admin

## Preview

![authorization_legend](resources/assets/legend.png)

## Installation

```shell
composer require laravel-admin-utils/authorization
```

Publish resources：

```shell
php artisan vendor:publish --provider="Elegant\Utils\Authorization\AuthorizationServiceProvider"
```

Initialization data

```shell
php artisan authorization:init
```

> The 'Administrator' has all the operation and menu permissions


open the `http://localhost/roles` manage roles

in the `http://localhost/administrators` you can add roles to administrator

### Action access control via routing

If you're using laravel-admin actions and want access control, let's take the user's 'replicate' as an example

- create action `app/Admin/Actions/Replicate.php`

  ```php
  namespace App\Admin\Actions;
  
  use Elegant\Utils\Actions\Response;
  use Elegant\Utils\Actions\RowAction;
  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Support\Facades\DB;
  
  class Replicate extends RowAction
  {
      /**
       * @var string
       */
      protected $method = 'POST';
  
      /**
       * @return array|null|string
       */
      public function name()
      {
          return 'replicate';
      }
  
      // getHandleUrl() or handle(Model $model) choose one of the two
  
      //========================if permission judgment is required use the method===========================
      /**
       * @return string
       */
      public function getHandleUrl()
      {
          return $this->parent->resource().'/'.$this->getKey().'/replicate';
      }
      
      //============If you don't need permission judgment, use the method=================
      ///**
      // * @param Model $model
      // *
      // * @return Response
      // */
      //public function handle(Model $model)
      //{
      //    try {
      //        DB::transaction(function () use ($model) {
      //            $model->replicate()->save();
      //        });
      //    } catch (\Exception $exception) {
      //        return $this->response()->error('replication failed！: ' . $exception->getMessage() . ')';
      //    }
  
      //    return $this->response()->success('replication successful！')->refresh();
      //}
      
      /**
       * @return void
       */
      public function dialog()
      {
          $this->question('confirm copy？');
      }
  }
  ```

- Controller replicate method
  ```php
  
  use Elegant\Utils\Http\Controllers\HandleController;
  
  class UserController extends AdminController
  {
      public function replicate($id)
      {
          // If permission judgment is required, perform logical processing here
          try {
              $model = User::withTrashed()->find($id);
              DB::transaction(function () use ($model) {
                  $model->replicate()->save();
              });
          } catch (\Exception $exception) {
              return $this->response()->error("replication failed！: {$exception->getMessage()}")->send();
          }
          return $this->response()->success('replication successful！')->refresh()->send();

          // If you don't need permission judgment, handle it in App\Admin\Actions\Replicate::handle() logic
          //return $this->handleAction();
      }
  }
  ```

### about the switch permission

Since the switch operation of laravel-admin itself is an update operation, the permissions cannot be judged independently

This section provides another action method to implement switch operation permission control, please refer to it [the](https://laravel-admin.org/docs/zh/2.x/model-table-column-display#列操作)
