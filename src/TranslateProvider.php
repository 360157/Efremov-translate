<?php

namespace Sashaef\TranslateProvider;

use Illuminate\Support\ServiceProvider;

class TranslateProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->app->make('Sashaef\TranslateProvider\Controllers\TranslateController');
        $this->loadViewsFrom(__DIR__.'/views', 'vocabulare');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__.'/routes.php';
    }
}
