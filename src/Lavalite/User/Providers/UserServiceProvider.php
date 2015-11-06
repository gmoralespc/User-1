<?php namespace Lavalite\User\Providers;

/**
 * Part of the Lavalite package.
 *
 *
 * @package    Lavalite
 * @version    5.1
 */


use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../../../../resources/views', 'user');
        $this->loadTranslationsFrom(__DIR__.'/../../../../resources/lang', 'user');

        $this->publishResources();

        $this->app->register(\Laravel\Socialite\SocialiteServiceProvider::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('user', function ($app) {
            return $app->make('Lavalite\User\User');
        });

        $this->app->bind(
            \Lavalite\User\Interfaces\RoleRepositoryInterface::class,
            \Lavalite\User\Repositories\Eloquent\RoleRepository::class
        );

        $this->app->singleton('user.role', function ($app) {
            return $app->make(\Lavalite\User\Interfaces\RoleRepositoryInterface::class);
        });

        $this->app->bind(
            \Lavalite\User\Interfaces\UserRepositoryInterface::class,
            \Lavalite\User\Repositories\Eloquent\UserRepository::class
        );

        $this->app->singleton('user.user', function ($app) {
            return $app->make(\Lavalite\User\Interfaces\UserRepositoryInterface::class);
        });

        $this->app->bind(
            \Lavalite\User\Interfaces\PermissionRepositoryInterface::class,
            \Lavalite\User\Repositories\Eloquent\PermissionRepository::class
        );

        $this->app->singleton('user.permission', function ($app) {
            return $app->make(\Lavalite\User\Interfaces\PermissionRepositoryInterface::class);
        });

        $this->app->singleton('user.auth', function ($app) {
            return $app['auth'];
        });

        //$this->app->register(\Lavalite\User\Providers\AuthServiceProvider::class);
        $this->app->register(\Lavalite\User\Providers\EventServiceProvider::class);
        $this->app->register(\Lavalite\User\Providers\RouteServiceProvider::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['user', 'user.role', 'user.permission', 'user.auth'];
    }

    /**
     * Publish resources.
     *
     * @return  void
     */
    private function publishResources()
    {
        // Publish configuration file
        $this->publishes([__DIR__.'/../../../../config/config.php'
                        => config_path('user.php')], 'config');

        // Publish admin view
        $this->publishes([__DIR__.'/../../../../resources/views/admin'
                        => base_path('resources/views/vendor/user/admin')], 'view-admin');

        // Publish language files
        $this->publishes([__DIR__.'/../../../../resources/lang'
                        => base_path('resources/lang/vendor/user')], 'lang');

        // Publish migrations
        $this->publishes([__DIR__.'/../../../../database/migrations/'
                        => base_path('database/migrations')], 'migrations');

        // Publish seeds
        $this->publishes([__DIR__.'/../../../../database/seeds/'
                        => base_path('database/seeds')], 'seeds');
    }
}
