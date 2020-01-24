<?php
/**
 * Created by PhpStorm.
 * User: ipeople
 * Date: 02.09.19
 * Time: 13:41
 */

namespace Sashaef\TranslateProvider\Traits;

use Sashaef\TranslateProvider\Models\Langs;
use Sashaef\TranslateProvider\Models\Langs as Model;
use Illuminate\Pagination\Paginator;

trait LangsTrait
{
    public static $langColumns = [
        'id',
        'index',
        'name',
        'is_active',
        'created_at',
        'updated_at'
    ];

    public static function getLangs($select = null)
    {
        switch ($select) {
            case 'yes':
                $isActive = true;
                break;
            case 'no':
                $isActive = false;
                break;
            default:
                $isActive = null;
                break;
        }

        return Model::getLangs($isActive);
    }

    public static function filterLangs($request)
    {
        switch ($request->isActive) {
            case 'yes': $request->isActive = true; break;
            case 'no': $request->isActive = false; break;
        }

        $order = [self::$langColumns[$request->order[0]['column'] ?? 0], $request->order[0]['dir'] ?? 'desc'];
        self::setPageByStart($request->start, $request->length);

        return Model::filterLangs([
            'is_active' => $request->isActive,
            'search' => $request->search
        ], $order, $request->length);
    }

    public static function getLang($id)
    {
        return Model::find($id);
    }

    public static function postLang($name, $index, $flag, $dir = 'ltr', $countries = null, $is_active = false)
    {
        return Model::postLangs($name, $index, $flag, $dir, $countries, $is_active);
    }

    public static function updateLang($id, $index, $name, $flag, $dir, $countries, $isActive, $isDefault)
    {
        $lang = self::getLang($id);

        if ($lang === null) {return ['status' => 'error', 'message' => 'The language is missing!'];}

        return $lang->update([
            'name' => $name,
            'index' => $index,
            'flag' => $flag,
            'dir' => $dir === 'ltr' ? false : true,
            'countries' => $countries,
            'is_active' => is_null($isActive) ? 0 : 1,
            'is_default' => is_null($isDefault) ? 0 : 1
        ]);
    }

    public static function deleteLang($id)
    {
        $lang = self::getLang($id);

        if ($lang === null) {return ['status' => 'error', 'message' => 'The language is missing!'];}

        if ($lang->transData->isNotEmpty()) {return ['status' => 'error', 'message' => 'The language has translations!'];}

        if ($lang->delete()) {
            return ['status' => 'success', 'message' => 'The language has deleted!'];
        } else {
            return ['status' => 'error', 'message' => 'Server error!'];
        }
    }

    public static function setPageByStart($start, $perPage)
    {
        if ($start === null ) {return;}

        $page = $start / ($perPage ?? (new Model)->getPerPage()) + 1;

        Paginator::currentPageResolver(function() use ($page) {return $page;});
    }

    public static function getLangId($lang)
    {
        return config('app.langs')[$lang]['id'] ?? null;
    }

    public static function getLangList()
    {
        return include_once (__DIR__ . '/../database/data/langs.php');
    }

    public static function getLangFlags()
    {
        $flags = Langs::query()->select('flag')->get()->pluck('flag');
        $countryList = self::getCountryList();

        /*foreach ($flags as $flag) {
            unset($countryList[strtoupper($flag)]);
        }*/

        return $countryList;
    }

    public static function getLangCountries()
    {
        $countries = Langs::query()->select('countries')->get()->pluck('countries')->implode(',');
        $countryList = self::getCountryList();

        /*foreach (explode(',', $countries) as $country) {
            unset($countryList[$country]);
        }*/

        return $countryList;
    }
}