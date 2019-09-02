<?php
/**
 * Created by PhpStorm.
 * User: ipeople
 * Date: 02.09.19
 * Time: 13:41
 */

namespace Sashaef\TranslateProvider\Traits;

use Sashaef\TranslateProvider\Models\Langs as Model;

trait Langs
{
    public function getLangs()
    {
        return Model::getLangs();
    }

    public function postLang($name, $index)
    {
        Model::postLangs($name, $index);
    }

    public function updateLang($id, $name, $index, $idActive)
    {
        Model::updateLangs($id, $name, $index, $idActive);
    }
}