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

        // Publish a config file
        $this->publishes([
            __DIR__.'/../../../../config/package.php' => config_path('package.php')
        ], 'config');

        // Publish your migrations
        $this->publishes([
            __DIR__.'/../../../database/migrations/' => database_path('/migrations')
        ], 'migrations');
        
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
            'Lavalite\\User\\Interfaces\\GroupInterface',
            'Lavalite\\User\\Models\\Group'
            );

        $this->app->bind(
            'Lavalite\\User\\Interfaces\\ThrottleInterface',
            'Lavalite\\User\\Models\\Throttle'
            );

        $this->app->bind(
            'Lavalite\\User\\Interfaces\\UserInterface',
            'Lavalite\\User\\Models\\User'
            );

        $this->app->bind(
            'Lavalite\\User\\Interfaces\\GroupProviderInterface',
            'Lavalite\\User\\Providers\\GroupProvider'
            );

        $this->app->bind(
            'Lavalite\\User\\Interfaces\\ThrottlingProviderInterface',
            'Lavalite\\User\\Providers\\ThrottlingProvider'
            );

        $this->app->bind(
            'Lavalite\\User\\Interfaces\\UserProviderInterface',
            'Lavalite\\User\\Providers\\UserProvider'
            );

        $this->app->bind(
            'Lavalite\\User\\Interfaces\\CookieInterface',
            'Lavalite\\User\\Stores\\IlluminateCookie'
            );

        $this->app->bind(
            'Lavalite\\User\\Interfaces\\SessionInterface',
            'Lavalite\\User\\Stores\\IlluminateSession'
            );
	}


}
