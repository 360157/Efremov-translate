<?php

namespace Sashaef\TranslateProvider\Models;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    protected $table = 'trans_groups';

    protected $fillable = ['name', 'type'];

    protected $perPage = 10;

    public function trans()
    {
        return $this->hasMany(Trans::class, 'group_id');
    }

    public static function storeGroup($name, $type)
    {
        return self::firstOrCreate([
            'name' => $name,
            'type' => $type
        ], [
            'name' => $name,
            'type' => $type
        ]);
    }

    public static function deleteGroup($id)
    {
        self::where('id', $id)->delete();
    }

    public static function filterGroups($filter, array $order = ['id', 'desc'], $perPage)
    {
        $result = self::query()
            ->where('type', $filter['type']);

        return $result->when($filter['search'], function ($q) use ($filter) {
            return $q->where('name', 'LIKE', '%'.$filter['search'].'%');
        })
            ->orderBy($order[0], $order[1])
            ->paginate($perPage);
    }

    public static function getAllGroups()
    {
        return self::get();
    }

    public static function getGroupName($id)
    {
        return self::where('id', $id)->value('name');
    }

    public static function getGroupCount($name, $type)
    {
        return self::where('name', $name)->where('type', $type)->count();
    }

    public static function getTransCount($id, $status = null)
    {
        $orders = self::join('trans', 'trans_groups.id', '=', 'trans.group_id');

        if (!is_null($status)) {
            $orders->join('trans_data', 'trans.id', '=', 'trans_data.translation_id');
        } else {
            $orders->leftJoin('trans_data', 'trans.id', '=', 'trans_data.translation_id')
                ->whereNull('trans_data.translation');
        }

        return $orders->where('trans_groups.id', $id)->groupBy('trans.id')->count();
    }
}
