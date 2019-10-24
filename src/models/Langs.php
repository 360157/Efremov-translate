<?php

namespace Sashaef\TranslateProvider\Models;

use Illuminate\Database\Eloquent\Model;

class Langs extends Model
{
    protected $table = 'langs';

    protected $fillable = ['name', 'index', 'is_active'];

    public function transData()
    {
        return $this->hasMany(TransData::class);
    }

    public static function getLangs($isActive = null)
    {
        $result = self::query();
        if (!is_null($isActive)) {$result->where('is_active', $isActive);}

        return $result->orderBy('id')
            ->get();
    }

    public static function postLangs($name, $index)
    {
        return self::create([
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
