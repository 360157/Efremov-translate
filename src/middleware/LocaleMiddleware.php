<?php

namespace Sashaef\TranslateProvider\middleware;

use Closure;
use App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request;
use Sashaef\TranslateProvider\Models\Langs;

class LocaleMiddleware
{
    public static $langs = [];
    public static $currentLang = null;
    public static $defaultLang = null;

    public function handle($request, Closure $next)
    {
        $langs = self::getLangs();
        self::$defaultLang = config('app.locale');
        self::$currentLang = Cookie::get('locale');

        if (empty(self::$currentLang)) {
            self::$currentLang = self::getLangByIp() ?? self::$defaultLang;
        }

        if (Cookie::has('locale') && self::getLangFromUrl() !== self::$currentLang) {
            self::$currentLang = self::getLangFromUrl() ?? self::$defaultLang;
        }

        Cookie::queue('locale', self::$currentLang);

        if (self::getLangFromUrl() === null && self::$currentLang !== self::$defaultLang) {
            return redirect('/'.self::$currentLang.'/'.Request::path());
        }

        App::setLocale(self::$currentLang);
        view()->share('nowLang', self::$currentLang);
        view()->share('nowLangId', $langs[self::$currentLang]['id']);

        return $next($request);
    }

    public static function getLocale()
    {
        self::$langs = self::getLangs();

        return self::getLangFromUrl() ?? env('ROUTING_LOCALE');
    }

    public static function getLangs()
    {
        if (!is_null(config('app.langs'))) return config('app.langs');

        $langs = [];
        try {
            foreach (Langs::getLangs(1) as $lang) {
                $langs[$lang->index] = [
                    'id' => $lang->id,
                    'index' => $lang->index,
                    'name' => $lang->name,
                    'flag' => $lang->flag,
                    'dir' => $lang->dir,
                    'countries' => $lang->countries ? explode(',', $lang->countries) : [],
                    'is_default' => $lang->is_default
                ];
            }
            config(['app.langs' => $langs]);
        } catch (\Exception $e) {}

        return $langs;
    }

    public static function getLangFromUrl()
    {
        $segmentsUri = explode('/', Request::path());

        return isset(self::$langs[$segmentsUri[0]]) ? $segmentsUri[0] : null;
    }

    public static function getLangByIp()
    {
        $geoip = geoip(Request::ip());
        $country = $geoip['iso_code'];
        $langCountries = array_column(config('app.langs'), 'countries', 'index');

        return key(array_filter($langCountries, function ($codes) use ($country) {
                return in_array($country, $codes) || in_array('*', $codes);
            })) ?? null;
    }
}
