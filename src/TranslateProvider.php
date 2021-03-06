<?php

namespace Sashaef\TranslateProvider;

use Illuminate\Support\ServiceProvider;
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
        $this->app->singleton('translator', function ($app) {
            $trans = new Translator(Redis::class, $app['config']['app.locale']);
            $trans->setFallback($app['config']['app.fallback_locale']);

            return $trans;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadViewsFrom(__DIR__.'/views', 'translate');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->publishes([
            __DIR__.'/views/assets' => public_path('vendor/translate'),
        ], 'public');
        $this->publishes([
            __DIR__.'/config/translate.php' => config_path('translate.php')
        ], 'config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                \Sashaef\TranslateProvider\Commands\CacheCommand::class,
                \Sashaef\TranslateProvider\Commands\RouteCacheCommand::class,
            ]);
        }
    }
}
