<?php

namespace Sashaef\TranslateProvider\Models;

use Illuminate\Database\Eloquent\Model;

class Langs extends Model
{
    protected $table = 'langs';

    protected $fillable = ['name', 'index', 'is_active'];

    public static function getLangs()
    {
        return self::get();
    }

    public static function postLangs($name, $index)
    {
        self::create([
            'name' => $name,
            'index' => $index
        ]);
    }

    public static function updateLangs($id, $name, $index, $isActive)
    {
        self::where('id', $id)->update([
            'name' => $name,
            'index' => $index,
            'is_active' => $isActive
        ]);
    }

    public static function deleteLangs($id)
    {
        self::where('id', $id)->delete();
    }
}
