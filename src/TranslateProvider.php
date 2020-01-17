<?php

namespace Sashaef\TranslateProvider;

use Illuminate\Support\ServiceProvider;
use Cache;
use Sashaef\TranslateProvider\Models\Langs;
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
        config(['app.langs' => self::getLangs()]);

        //$this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->publishes([
            __DIR__.'/views/assets' => public_path('vendor/translate'),
        ], 'public');
        $this->publishes([
            __DIR__.'/config/translate.php' => config_path('translate.php')
        ], 'config');
    }

    public static function getLangs()
    {
        return Cache::rememberForever('app.langs', function () {
            $langs = [];
            foreach (Langs::query()->where('is_active', true)->get() as $lang) {
                $langs[$lang->index] = [
                    'id' => $lang->id,
                    'index' => $lang->index,
                    'name' => $lang->name,
                    'flag' => $lang->flag,
                    'is_default' => $lang->is_default
                ];
            }

            return $langs;
        });
    }
}
