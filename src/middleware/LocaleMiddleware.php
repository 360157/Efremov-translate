<?php

namespace Sashaef\TranslateProvider\middleware;

use Closure;
use App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request;
use Sashaef\TranslateProvider\Models\Langs;

class LocaleMiddleware
{
    private static $langs = [];

    public function handle($request, Closure $next)
    {
        $langs = self::getLangs();
        $defaultLang = config('app.locale');
        $currentLang = Cookie::get('locale');

        if (empty($currentLang)) {
            $currentLang = self::getLangByIp() ?? $defaultLang;
        }

        if (Cookie::has('locale') && self::getLangFromUrl() !== $currentLang) {
            $currentLang = self::getLangFromUrl() ?? $defaultLang;
        }

        Cookie::queue('locale', $currentLang);

        if (self::getLangFromUrl() === null && $currentLang !== $defaultLang) {
            return redirect('/'.$currentLang.'/'.Request::path());
        }

        App::setLocale($currentLang);
        view()->share('nowLang', $currentLang);
        view()->share('nowLangId', $langs[$currentLang]['id']);

        return $next($request);
    }

    public static function getLocale()
    {
        self::$langs = self::getLangs();

        return self::getLangFromUrl();
    }

    public static function getLangs()
    {
        if (!is_null(config('app.langs'))) return config('app.langs');

        $langs = [];
        try {
            foreach (Langs::query()->where('is_active', true)->get() as $lang) {
                $langs[$lang->index] = [
                    'id' => $lang->id,
                    'index' => $lang->index,
                    'name' => $lang->name,
                    'flag' => $lang->flag,
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

        $langs = config('translate.country');

        return $langs[$geoip['iso_code']] ?? $langs['*'] ?? null;
    }
}
