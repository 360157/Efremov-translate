<?php

namespace Sashaef\TranslateProvider;

use Illuminate\Support\ServiceProvider;
use Sashaef\TranslateProvider\Translator;
use Illuminate\Support\Facades\Redis;

class TranslateProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();

        $this->app->singleton('translator', function ($app) {
            $trans = new Translator(Redis::class, $app['config']['app.locale']);
            $trans->setFallback($app['config']['app.fallback_locale']);
            $trans->setType('interface');

            return $trans;
        });

        $this->app->make('Sashaef\TranslateProvider\Controllers\TranslateController');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadViewsFrom(__DIR__.'/views', 'vocabulare');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->publishes([
            __DIR__.'/views/assets' => public_path('vendor/vocabulare'),
        ], 'public');
    }
}
