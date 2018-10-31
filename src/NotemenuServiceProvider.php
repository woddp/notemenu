<?php

namespace Woddp\Notemenu;

use Illuminate\Support\ServiceProvider;
use Woddp\Notemenu\main\Notemenu;

class NotemenuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('notemenu', function ($app) {
            return new Notemenu($app['session'], $app['config']);
        });
    }

    public function provides()
    {
        return ['notemenu'];
    }
}
