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
        config(['app.langs' => self::$languages = self::getLangs()]);
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
