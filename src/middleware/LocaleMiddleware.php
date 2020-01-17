<?php

namespace Sashaef\TranslateProvider\middleware;

use Closure;
use App;
use Request;
use Cache;
use Sashaef\TranslateProvider\Models\Langs;

class LocaleMiddleware
{
    public static $mainLanguage = null;

    public static $languages = [];

    public function __construct()
    {
        self::$mainLanguage = config('app.locale');
        $languages = config('app.locales');
        unset($languages[array_search(self::$mainLanguage, $languages)]);
        self::$languages = $languages;
    }

    public static function getLocale()
    {
        self::$languages = config('app.langs');
        $uri = Request::path();
        $segmentsURI = explode('/', $uri);

        if (!empty($segmentsURI[0]) && isset(self::$languages[$segmentsURI[0]])) {
            if ($segmentsURI[0] != self::$mainLanguage) {
                return $segmentsURI[0];
            }
        }

        return null;
    }

    public function handle($request, Closure $next)
    {
        $locale = self::getLocale() ?: self::$mainLanguage;

        App::setLocale($locale);
        view()->share('nowLang', $locale);
        view()->share('nowLangId', self::$languages[$locale]['id']);

        return $next($request);
    }
}
