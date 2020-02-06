<?php

namespace Sashaef\TranslateProvider\Commands;

use Illuminate\Routing\RouteCollection;
use Illuminate\Support\Facades\Request;
use Sashaef\TranslateProvider\Models\Langs;

class RouteCacheCommand extends \Illuminate\Foundation\Console\RouteCacheCommand
{
    /**
     * @var string
     */
    protected $name = 'translate:route:cache';

    protected $signature = 'translate:route:cache';

    protected $translatedRoutes = [];
    /**
     * @var string
     */
    protected $description = 'Create a route cache file for faster route registration for all locales';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('route:clear');

        $this->cacheRoutesPerLocale();

        $this->info('Routes cached successfully for all locales!');
    }

    /**
     * Cache the routes separately for each locale.
     */
    protected function cacheRoutesPerLocale()
    {
        $allLocales = Langs::getLangs(1)->pluck('index')->toArray();

        array_push($allLocales, null);

        foreach ($allLocales as $locale) {
            $_SERVER['REQUEST_URI'] = $locale;

            $routes = $this->getFreshApplicationRoutesForLocale($locale);

            if (count($routes) == 0) {
                $this->error("Your application doesn't have any routes.");
                return;
            }

            foreach ($routes as $route) {
                $route->prepareForSerialization();
            }

            $this->files->put(
                $this->makeLocaleRoutesPath($locale), $this->buildRouteCacheFile($routes)
            );
        }
    }

    /**
     * Boot a fresh copy of the application and get the routes for a given locale.
     *
     * @param string|null $locale
     * @return \Illuminate\Routing\RouteCollection
     */
    protected function getFreshApplicationRoutesForLocale($locale = null)
    {
        if ($locale === null) {
            return $this->getFreshApplicationRoutes();
        }

        putenv("ROUTING_LOCALE={$locale}");

        $routes = $this->getFreshApplicationRoutes();

        putenv("ROUTING_LOCALE=");

        return $routes;
    }

    /**
     * Build the route cache file.
     *
     * @param  \Illuminate\Routing\RouteCollection $routes
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildRouteCacheFile(RouteCollection $routes)
    {
        $stub = $this->files->get(__DIR__ . '/../stubs/routes.stub');

        return str_replace(
            [
                '{{routes}}',
                '{{translatedRoutes}}',
            ],
            [
                base64_encode(serialize($routes)),
                $this->getSerializedTranslatedRoutes(),
            ],
            $stub
        );
    }

    /**
     * @param string $locale
     * @return string
     */
    protected function makeLocaleRoutesPath($locale = '')
    {
        $path = $this->laravel->getCachedRoutesPath();

        if ( ! $locale ) {
            return $path;
        }

        return substr($path, 0, -4) . '_' . $locale . '.php';
    }

    /**
     * Returns serialized translated routes for caching purposes.
     *
     * @return string
     */
    public function getSerializedTranslatedRoutes()
    {
        return base64_encode(serialize($this->translatedRoutes));
    }
}
