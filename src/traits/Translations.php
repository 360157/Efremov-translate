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

trait Translations
{
    public function storeTranslation($key, $group_id)
    {
        $trans = Trans::postTrans($group_id, $key);
        foreach (Langs::getLangs() as $lang) {
            TransData::postTransData($trans->id, $lang->id, 0);
        }
    }

    public function getTranslations($group_id)
    {
        $trans = Trans::getByGroup($group_id);

        $transData = array();
        foreach ($trans as $value) {
            $transData[$value->id] = $value->data->toArray();
        }
        foreach ($transData as $k => $value) {
            foreach ($value as $i => $item) {
                $transData[$k][$i]['value'] = 'NULL';
            }
        }

        return [
            'trans' => $trans,
            'transData' => $transData
        ];
    }
}