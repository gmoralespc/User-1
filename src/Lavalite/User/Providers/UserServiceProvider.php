<?php namespace Lavalite\User\Providers;
/**
 * Part of the Lavalite package.
 *
 *
 * @package    Lavalite
 * @version    2.0.0
 */


use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider {

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
        $this->publishMigrations();

        $this->app->register('\Artesaos\Defender\Providers\DefenderServiceProvider');
        $this->app->register('\Laravel\Socialite\SocialiteServiceProvider');

        include __DIR__ . '/../Http/routes.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->bind('user', function ($app) {
            return $this->app->make('Lavalite\User\User');
        });

        $this->app->bind(
            'Lavalite\\User\\Interfaces\\RoleRepositoryInterface',
            'Lavalite\\User\\Repositories\\Eloquent\\RoleRepository'
        );

        $this->app->bind(
            'Lavalite\\User\\Interfaces\\UserRepositoryInterface',
            'Lavalite\\User\\Repositories\\Eloquent\\UserRepository'
        );

        $this->app->bind(
            'Lavalite\\User\\Interfaces\\PermissionRepositoryInterface',
            'Lavalite\\User\\Repositories\\Eloquent\\PermissionRepository'
        );
	}

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('user');
    }

    /**
     * Publish configuration file.
     */
    private function publishResources()
    {
        $this->publishes([__DIR__.'/../../../../config/config.php' => config_path('user.php')], 'config');
    }

    /**
     * Publish migration file.
     */
    private function publishMigrations()
    {
        $this->publishes([__DIR__.'/../../../../databases/migrations/' => base_path('database/migrations')], 'migrations');
    }

}
