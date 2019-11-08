<?php

namespace Sashaef\TranslateProvider\Models;

use Illuminate\Database\Eloquent\Model;

class Langs extends Model
{
    protected $table = 'langs';

    protected $fillable = ['name', 'index', 'is_active'];

    protected $perPage = 10;

    public function transData()
    {
        return $this->hasMany(TransData::class, 'lang_id');
    }

    public static function getLangs($isActive = null)
    {
        $result = self::query();
        if (!is_null($isActive)) {$result->where('is_active', $isActive);}

        return $result->orderBy('id')
            ->get();
    }

    public static function filterLangs($filter, array $order = ['id', 'desc'], $perPage = 1)
    {
        $result = self::query();

        if (!is_null($filter['is_active'])) {$result->where('is_active', $filter['is_active']);}

        return $result->when($filter['search'], function ($q) use ($filter) {
            return $q->where('index', 'LIKE', '%'.$filter['search'].'%')
                ->orWhere('name', 'LIKE', '%'.$filter['search'].'%');
            })
            ->orderBy($order[0], $order[1])
            ->paginate($perPage);
    }

    public static function postLangs($name, $index)
    {
        return self::firstOrCreate([
            'index' => $index
        ], [
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
