<?php
/**
 * Created by PhpStorm.
 * User: ipeople
 * Date: 03.09.19
 * Time: 16:28
 */

namespace Sashaef\TranslateProvider\Traits;

use Illuminate\Pagination\Paginator;
use Sashaef\TranslateProvider\Models\Countries;

trait CountriesTrait
{
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
        return include_once (__DIR__ . '/../database/data/countries.php');
    }
}
