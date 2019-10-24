<?php

namespace Sashaef\TranslateProvider\TranslationLoaders;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redis;
use Sashaef\TranslateProvider\Models\TransData;

class Db implements TranslationLoader
{
    public function loadTranslations(string $locale, string $group): array
    {
        dd(Redis::get('interface:main:main.create:'));

        //dd([Redis::get('interface'.':'.$group.':'.'main.create'.':'.'1')]);

        //dd(Redis::get('interface'.':'.$group.':'.$transData[$k][$i]['key'].':'.$locale));

        if ($locale == 'en') {
            return ['create' => 'Create', 'filter' => 'Filter'];
        }

        if ($locale == 'uk') {
            return ['create' => 'Створити', 'filter' => 'Фільтрувати'];
        }

        /*return Cache::rememberForever(static::getCacheKey($group, $locale), function () use ($group, $locale) {
            /*return TransData::query()
                    ->where('group', $group)
                    ->get()
                    ->reduce(function ($lines, self $languageLine) use ($locale) {
                        $translation = $languageLine->getTranslation($locale);

                        if ($translation !== null) {
                            Arr::set($lines, $languageLine->key, $translation);
                        }

                        return $lines;
                    }) ?? [];
            return ['create' => 'dfgdfg'];
        });*/
    }

    public static function getCacheKey(string $group, string $locale): string
    {
        return "spatie.translation-loader.{$group}.{$locale}";
    }
}
