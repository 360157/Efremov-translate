<?php

namespace Sashaef\TranslateProvider\Models;

use Illuminate\Database\Eloquent\Model;

class Trans extends Model
{
    protected $table = 'trans';

    protected $fillable = ['group_id', 'key'];

    public function group()
    {
        return $this->belongsTo(Groups::class);
    }

    public function data()
    {
        return $this->hasMany(TransData::class, 'translation_id');
    }

    public static function postTrans($group_id, $key)
    {
        return self::create([
            'group_id' => $group_id,
            'key' => $key
        ]);
    }

    public static function getByGroup($group_id)
    {
        return self::where('group_id', $group_id)->get();
    }

    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function getTransCount($group_id, $key)
    {
        return self::where('group_id', $group_id)->where('key', $key)->count();
    }
}
