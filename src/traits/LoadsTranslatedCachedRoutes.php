<?php

namespace Sashaef\TranslateProvider\traits;

use Illuminate\Routing\Route;
use Log;
use Sashaef\TranslateProvider\middleware\LocaleMiddleware;

trait LoadsTranslatedCachedRoutes
{
    /**
     * Load the cached routes for the application.
     *
     * @return void
     */
    protected function loadCachedRoutes()
    {
        $locale = LocaleMiddleware::getLocale();

        $localeKeys = LocaleMiddleware::getLangs();

        $path = $this->makeLocaleRoutesPath($locale, $localeKeys);

        if (!file_exists($path)) {
            Log::warning("Routes cached, but no cached routes found for locale '{$locale}'!");

            $path = $this->getDefaultCachedRoutePath();
        }

        $this->app->booted(function () use ($path) {
            require $path;
        });
    }

    /**
     * Returns the path to the cached routes file for a given locale.
     *
     * @param string   $locale
     * @param string[] $localeKeys
     * @return string
     */
    protected function makeLocaleRoutesPath($locale, $localeKeys)
    {
        $path = $this->getDefaultCachedRoutePath();

        if ( ! $locale || ! array_key_exists($locale, $localeKeys)) {
            return $path;
        }

        return substr($path, 0, -4) . '_' . $locale . '.php';
    }

    /**
     * Returns the path to the standard cached routes file.
     *
     * @return string
     */
    protected function getDefaultCachedRoutePath()
    {
        return $this->app->getCachedRoutesPath();
    }
}