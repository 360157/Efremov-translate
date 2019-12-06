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

trait Translations
{
    public static $translateColumns = [
        'id',
        'key',
    ];

    public function storeTranslation($type, $group_id, $key, $description, $translates, $statuses)
    {
        $groupKey = Groups::getGroupName($group_id);

        $trans = Trans::createKey($group_id, $key, $description);

        if ($trans->wasRecentlyCreated) {
            foreach (Langs::getLangs() as $lang) {
                if (!empty($translates[$lang->id])) {
                    TransData::postTransData($trans->id, $lang->id, $translates[$lang->id], isset($statuses[$lang->id]) ? 2 : 1);

                    Redis::set($type.':'.$groupKey.':'.$key.':'.$lang->id, $translates[$lang->id]);
                }
            }

            return true;
        }

        return false;
    }

    public function filterTranslates($request)
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

    public function updateTranslation_($translations, $group_id, $type, $isChecked)
    {
        $groupKey = Groups::getGroupName($group_id);
        foreach ($translations as $k => $trans) {
            $transDbRow = Trans::getById($k);

            foreach ($transDbRow->data as $transData) {
                $transData->translation = $trans[$transData->lang_id];
                $transData->status = is_array($isChecked) && array_key_exists($transData->id, $isChecked) ? 2 : 1;
                $transData->update();
            }

            foreach ($trans as $i => $word) {
                Redis::set($type.':'.$groupKey.':'.$transDbRow->key.':'.$i, $word);
            }
        }
    }

    public function getTransByKey($keys)
    {
        $response = array();
        foreach ($keys as $key) {
            $response[$key] = Redis::get($key);
        }
        return $response;
    }

    private function filterTrans($trans)
    {
        $withTrans = array();
        $withoutTrans = array();
        foreach ($trans as $value) {
            $checkStatus = 0;
            foreach ($value->data as $data) {
                if ( $data->status != 2) {
                    $checkStatus++;
                }
            }
            if ( $checkStatus == 0) {
                $withTrans[] = $value;
            } else {
                $withoutTrans[] = $value;
            }
        }

        return array_merge($withoutTrans, $withTrans);
    }

    function updateKey($id, $value, $description)
    {
        $trans = Trans::find($id);

        return $trans->update(['key' => $value, 'description' => $description]);
    }

    function updateTranslation($key, $lang, $translation, $status)
    {
        $trans = Trans::find($key);

        if (!empty($translation)) {
            Redis::set($trans->group->type.':'.$trans->group->name.':'.$trans->key.':'.$lang, $translation);
        }

        return $trans->data()->updateOrCreate([
            'lang_id' => $lang
        ], [
            'translation' => $translation,
            'status' => $status ?? 1
        ]);
    }
}