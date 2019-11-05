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
    public function getGroups($type)
    {
        $groups = Model::getGroups($type);

        foreach ($groups as $k => $group) {
            $groups[$k]['trans'] = Model::getTransCount($group['id'], 'active');
            $groups[$k]['not_trans'] = Model::getTransCount($group['id']);
        }

        return $groups;
    }

    public function getGroup($id)
    {
        return Model::find($id);
    }

    public function storeGroup($name, $type)
    {
        Model::storeGroup($name, $type);
    }

    public function updateGroup($id, $name)
    {
        $group = $this->getGroup($id);

        if ($group === null) {return ['status' => 'error', 'message' => 'The group is missing!'];}

        if ($group->update([
            'name' => $name,
        ])) {
            return ['status' => 'success', 'message' => 'The group has updated!'];
        } else {
            return ['status' => 'error', 'message' => 'Server error!'];
        }
    }

    public function deleteGroup($id)
    {
        $group = $this->getGroup($id);

        if ($group === null) {return ['status' => 'error', 'message' => 'The group is missing!'];}

        if ($group->trans->isNotEmpty()) {return ['status' => 'error', 'message' => 'The group has translations!'];}

        if ($group->delete()) {
            return ['status' => 'success', 'message' => 'The group has deleted!'];
        } else {
            return ['status' => 'error', 'message' => 'Server error!'];
        }
    }

    public function getAllGroups()
    {
        return Model::getAllGroups();
    }
}
