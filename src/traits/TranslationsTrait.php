<?php
/**
 * Created by PhpStorm.
 * User: ipeople
 * Date: 04.09.19
 * Time: 16:01
 */

namespace Sashaef\TranslateProvider\Traits;

use Sashaef\TranslateProvider\Models\Trans;
use Sashaef\TranslateProvider\Models\TransData;
use Sashaef\TranslateProvider\Models\Langs;
use Sashaef\TranslateProvider\Models\Groups;
use Illuminate\Support\Facades\Redis;
use Illuminate\Pagination\Paginator;
use Sashaef\TranslateProvider\Traits\{RedisTrait, LangsTrait};

trait TranslationsTrait
{
    use RedisTrait;
    use LangsTrait;

    public static $translateColumns = [
        'id',
        'key',
    ];

    public static function filterTranslates($request)
    {
        $order = ['trans.'.self::$translateColumns[$request->order[0]['column'] ?? 0], $request->order[0]['dir'] ?? 'desc'];
        $page = $request->start / $request->length + 1;
        Paginator::currentPageResolver(function() use ($page) {return $page;});

        return Trans::filterTranslates([
            'group' => $request->group_id,
            'key' => $request->keyText,
            'translation' => $request->translationText,
            'status' => $request->verified,
            'translated' => $request->translated,
        ], $order, $request->length);
    }

    public static function storeTranslation($type, $group_id, $key, $description, $translates, $statuses)
    {
        $groupKey = Groups::getGroupName($group_id);

        $trans = Trans::createKey($group_id, $key, $description);

        if ($trans->wasRecentlyCreated) {
            foreach (Langs::getLangs() as $lang) {
                if (!empty($translates[$lang->id])) {
                    TransData::postTransData($trans->id, $lang->id, $translates[$lang->id], isset($statuses[$lang->id]) ? 2 : 1);

                    self::redisSet($type, $groupKey, $key, $lang->id, $translates[$lang->id]);
                }
            }

            return true;
        }

        return false;
    }

    public static function storeTranslations($group, $translates, $statuses)
    {
        try {
            foreach ($translates as $key => $translations) {
                $trans = Trans::createKey($group->id, $key);

                foreach ($translations as $lang => $translation) {
                    TransData::postTransData($trans->id, $lang, $translation, $statuses);

                    self::redisSet($group->type, $group->name, $key, $lang, $translation);
                }
            }

            return true;
        } catch (\Exception $e) {
            return true;
        }
    }

    public static function updateKey($id, $value, $description)
    {
        $trans = Trans::find($id);

        return $trans->update(['key' => $value, 'description' => $description]);
    }

    public static function updateTranslation($key, $lang, $translation, $status)
    {
        $trans = Trans::find($key);
        $group = $trans->group;

        if (!empty($translation)) {
            self::redisSet($group->type, $group->name, $trans->key, $lang, $translation);
        }

        return $trans->data()->updateOrCreate([
            'lang_id' => $lang
        ], [
            'translation' => $translation,
            'status' => $status ?? 1
        ]);
    }

    public static function restartTranslation($id)
    {
        $group = Groups::find($id);
        $langIds = Langs::getLangs(1)->pluck('id');

        self::redisDelete($group->type.':'.$group->name.':*');

        $translates = $group->trans()
            ->select([
                'key',
                'translation',
                'lang_id',
            ])
            ->join('trans_data', 'trans.id', '=', 'trans_data.translation_id')
            ->whereIn('lang_id', $langIds)
            ->whereNotNull('translation')
            ->get();

        Redis::pipeline(function ($pipe) use ($translates, $group)  {
            foreach ($translates as $translate) {
                $pipe->set($group->type.':'.$group->name.':'.$translate->key.':'.$translate->lang_id, $translate->translation);
            }
        });

        return true;
    }

    public static function getTranslations($type = 'interface', $lang = 'en', $keys = [])
    {
        if (is_null($lang)) {return [];}

        $langId = self::getLangId($lang);
        $translations = [];

        if (empty($keys)) {
            foreach(Redis::keys("$type:*:*:$langId") as $key) {
                $keyArr = explode(':', $key, 4);

                if (!isset($keyArr[1]) || !isset($keyArr[2])) {continue;}

                $translations[$keyArr[1]][$keyArr[2]] = Redis::get($key);
            }
        } else {
            foreach($keys as $key) {
                $keyArr = explode('.', $key, 2);

                if (!isset($keyArr[0]) || !isset($keyArr[1])) {continue;}

                $translations[$keyArr[0]][$keyArr[1]] = Redis::get("$type:$keyArr[0]:$keyArr[1]:$langId");
            }
        }

        return $translations;
    }
}