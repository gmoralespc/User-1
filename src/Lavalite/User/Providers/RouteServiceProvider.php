<?php

namespace Lavalite\User\Providers;

use Lavalite\User\Models\User;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Lavalite\User\Interfaces\UserRepositoryInterface;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Lavalite\User\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        $router->bind('user', function ($id) {
            $user = $this->app->make(\Lavalite\User\Interfaces\UserRepositoryInterface::class);
            return  $user -> find($id);
        });

        $router->bind('role', function ($id) {
            $role = $this->app->make(\Lavalite\User\Interfaces\RoleRepositoryInterface::class);
            return  $role -> find($id);
        });

        $router->bind('permission', function ($id) {
            $permission = $this->app->make(\Lavalite\User\Interfaces\PermissionRepositoryInterface::class);
            return  $permission -> find($id);
        });

        parent::boot($router);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($router) {
            require __DIR__.'/../Http/routes.php';
        });
    }
}
