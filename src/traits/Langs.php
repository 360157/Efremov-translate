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

    public function getLang($id)
    {
        return Model::find($id);
    }

    public function postLang($name, $index)
    {
        return Model::postLangs($name, $index);
    }

    public function updateLang($id, $name, $index, $isActive)
    {
        $isActive = is_null($isActive) ? 0 : 1;
        Model::updateLangs($id, $name, $index, $isActive);
    }

    public function deleteLang($id)
    {
        $lang = $this->getLang($id);

        if ($lang === null) {return ['status' => 'error', 'message' => 'The language is missing!'];}

        if ($lang->transData->isNotEmpty()) {return ['status' => 'error', 'message' => 'The language has translations!'];}

        if ($lang->delete()) {
            return ['status' => 'success', 'message' => 'The language has deleted!'];
        } else {
            return ['status' => 'error', 'message' => 'Server error!'];
        }
    }
}