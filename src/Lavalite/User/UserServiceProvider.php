<?php namespace Lavalite\User;

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('lavalite/user');
        include __DIR__.'/../../routes.php';
        include __DIR__.'/../../observer.php';
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
            'Lavalite\\User\\Interfaces\\SessionInterface',
            'Lavalite\\User\\Repositories\\Eloquent\\SessionRepository'
            );

        $this->app->bind(
            'Lavalite\\User\\Interfaces\\UserInterface',
            'Lavalite\\User\\Repositories\\Eloquent\\UserRepository'
            );

        $this->app->bind(
            'Lavalite\\User\\Interfaces\\GroupInterface',
            'Lavalite\\User\\Repositories\\Eloquent\\GroupRepository'
            );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

}
