<?php
/**
 * Created by PhpStorm.
 * User: ipeople
 * Date: 03.09.19
 * Time: 16:28
 */

namespace Sashaef\TranslateProvider\Traits;

use Sashaef\TranslateProvider\Models\Groups as Model;
use Illuminate\Pagination\Paginator;

trait Groups
{
    public static $groupColumns = [
        'id',
        'name',
        'type',
        'created_at',
        'updated_at'
    ];

    public function filterGroups($request)
    {
        $order = [self::$groupColumns[$request->order[0]['column'] ?? 0], $request->order[0]['dir'] ?? 'desc'];

        $page = $request->start / $request->length + 1;
        Paginator::currentPageResolver(function() use ($page) {return $page;});

        $groups = Model::filterGroups([
            'type' => $request->type,
            'search' => $request->search
        ], $order, $request->length);

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
        return Model::storeGroup($name, $type);
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

    public function deleteGroup($id, $trans = false)
    {
        $group = $this->getGroup($id);

        if ($group === null) {return ['status' => 'error', 'message' => 'The group is missing!'];}

        if ($trans === false && $group->trans->isNotEmpty()) {return ['status' => 'error', 'message' => 'The group has translations!'];}

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
