<?php
/**
 * Created by PhpStorm.
 * User: ipeople
 * Date: 02.09.19
 * Time: 13:41
 */

namespace Sashaef\TranslateProvider\Traits;

use Sashaef\TranslateProvider\Models\Langs as Model;
use Sashaef\TranslateProvider\Traits\Groups;
use Sashaef\TranslateProvider\Models\TransData;
use Illuminate\Support\Facades\Redis;

trait Langs
{
    use Groups;

    public function getLangs($select = null)
    {
        switch ($select) {
            case 'active':
                $isActive = true;
                break;
            case 'notActive':
                $isActive = false;
                break;
            default:
                $isActive = null;
                break;
        }
        return Model::getLangs($isActive);
    }

    public function postLang($name, $index)
    {
        $lang = Model::postLangs($name, $index);
        $groups = $this->getAllGroups();
        foreach ($groups as $group) {
            foreach ($group->trans as $trans) {
                TransData::postTransData($trans->id, $lang->id, 0);
                Redis::set($group->type.':'.$group->name.':'.$trans->key.':'.$lang->id, '');
            }
        }
    }

    public function updateLang($id, $name, $index, $isActive)
    {
        $isActive = is_null($isActive) ? 0 : 1;
        Model::updateLangs($id, $name, $index, $isActive);
    }

    public function deleteLang($id)
    {
        Model::deleteLangs($id);
    }


}