<?php
/**
 * Created by PhpStorm.
 * User: ipeople
 * Date: 03.09.19
 * Time: 16:28
 */

namespace Sashaef\TranslateProvider\Traits;

use Sashaef\TranslateProvider\Models\Groups as Model;

trait Groups
{
    public function storeGroup($name, $type)
    {
        Model::storeGroup($name, $type);
    }

    public function deleteGroup($id)
    {
        Model::deleteGroup($id);
    }

    public function getGroups($type)
    {
        return Model::getGroups($type);
    }
}