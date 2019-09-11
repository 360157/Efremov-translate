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

trait Translations
{
    public function storeTranslation($key, $group_id, $type)
    {
        $trans = Trans::postTrans($group_id, $key);
        $groupKey = Groups::getGroupName($group_id);
        foreach (Langs::getLangs() as $lang) {
            TransData::postTransData($trans->id, $lang->id, 0);
            Redis::set($type.':'.$groupKey.':'.$key.':'.$lang->id, '');
        }
    }

    public function getTranslations($group_id, $type, $isFilter)
    {

        $trans = Trans::getByGroup($group_id);
        $groupKey = Groups::getGroupName($group_id);
        $transData = array();
        foreach ($trans as $value) {
            $transData[$value->id] = $value->data->toArray();
            foreach ($transData[$value->id] as $k => $transArray) {
                $transData[$value->id][$k]['key'] = $value->key;
            }
        }
        foreach ($transData as $k => $value) {
            foreach ($value as $i => $item) {
                $transData[$k][$i]['value'] = Redis::get($type.':'.$groupKey.':'.$transData[$k][$i]['key'].':'.$item['lang_id']);
            }
        }

        if (!is_null( $isFilter)) {
            $trans = $this->filterTrans($trans);
        }

        return [
            'trans' => $trans,
            'transData' => $transData
        ];
    }

    public function updateTranslation($translations, $group_id, $type, $isChecked)
    {
        $isChecked = array_keys($isChecked);
        $groupKey = Groups::getGroupName($group_id);
        foreach ($translations as $k => $trans) {
            $transDbRow = Trans::getById($k);
            foreach ($trans as $i => $word) {
                Redis::set($type.':'.$groupKey.':'.$transDbRow->key.':'.$i, $word);
            }
            foreach ($transDbRow->data as $transData) {
                $status = in_array($transData->id, $isChecked) ? 2 : 1;
                TransData::updateStatus($transData->id, $status);
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
}