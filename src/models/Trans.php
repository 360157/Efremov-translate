<?php

namespace Sashaef\TranslateProvider\Models;

use Illuminate\Database\Eloquent\Model;

class Trans extends Model
{
    protected $table = 'trans';

    protected $fillable = ['group_id', 'key', 'description'];

    protected $perPage = 20;

    public function group()
    {
        return $this->belongsTo(Groups::class);
    }

    public function data()
    {
        return $this->hasMany(TransData::class, 'translation_id')->orderBy('lang_id');
    }

    public static function createKey($group_id, $key, $description = null)
    {
        return self::firstOrCreate([
            'group_id' => $group_id,
            'key' => $key
        ], [
            'group_id' => $group_id,
            'key' => $key,
            'description' => $description
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
}