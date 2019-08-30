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
        $this->app->make('Sashaef\TranslateProvider\TranslateController');
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
