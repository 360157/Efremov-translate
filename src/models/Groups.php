<?php

namespace Sashaef\TranslateProvider\Models;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    protected $table = 'trans_groups';

    protected $fillable = ['name', 'type'];

    public function trans()
    {
        return $this->hasMany(Trans::class, 'group_id');
    }

    public static function storeGroup($name, $type)
    {
        self::create([
            'name' => $name,
            'type' => $type
        ]);
    }

    public static function deleteGroup($id)
    {
        self::where('id', $id)->delete();
    }

    public static function getGroups($type)
    {
        return self::where('type', $type)->get();
    }

    public static function getAllGroups()
    {
        return self::get();
    }

    public static function getGroupName($id)
    {
        return self::where('id', $id)->value('name');
    }

    public static function getTransCount($id, $status = null)
    {
        $orders = self::join('trans', 'trans_groups.id', '=', 'trans.group_id')
            ->join('trans_data', 'trans.id', '=', 'trans_data.translation_id')
            ->where('trans_groups.id', $id);
        if (!is_null($status)) {
            $orders = $orders->where('trans_data.status', 2);
        } else {
            $orders = $orders->where('trans_data.status', '!=',  2);
        }
        $orders = $orders->count();

        return $orders;
    }
}
