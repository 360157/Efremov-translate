<?php
/**
 * Created by PhpStorm.
 * User: ipeople
 * Date: 03.09.19
 * Time: 16:28
 */

namespace Sashaef\TranslateProvider\Traits;

use Sashaef\TranslateProvider\Models\Countries;

trait CountriesTrait
{
    private static $countryList = [];

    public function getCountries($isActive = null)
    {
        return Countries::query()
            ->when($isActive, function ($q) use ($isActive) {
                return $q->where('is_active', $isActive);
            })
            ->get();
    }

    public static function getCountryList()
    {
        return self::$countryList ?: self::$countryList = include_once (__DIR__ . '/../database/data/countries.php');
    }
}
