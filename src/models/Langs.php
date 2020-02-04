<?php

namespace Sashaef\TranslateProvider\Models;

use Illuminate\Database\Eloquent\Model;

class Langs extends Model
{
    protected $table = 'langs';

    protected $fillable = ['name', 'index', 'flag', 'dir', 'countries', 'is_active', 'is_default', 'created_at', 'updated_at'];

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

    public static function filterLangs($filter, array $order = ['id', 'desc'], $perPage = null)
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

    public static function getLangsById($lang_id = null)
    {
        if (is_null($lang_id) || $lang_id == 'all') {
            $result = self::get();
        } else {
            $result = self::where('id', $lang_id)->get();
        }

        return $result;
    }

    public static function postLangs($name, $index, $flag, $dir = 'ltr', $countries = null, $is_active = false)
    {
        return self::firstOrCreate([
            'index' => $index
        ], [
            'name' => $name,
            'index' => strtolower($index),
            'flag' => strtolower($flag),
            'dir' => $dir === 'ltr' ? false : true,
            'countries' => $countries,
            'is_active' => $is_active
        ]);
    }

    public static function updateLangs($id, $name, $index, $flag, $isActive)
    {
        self::where('id', $id)->update([
            'name' => $name,
            'index' => $index,
            'flag' => $flag,
            'is_active' => $isActive
        ]);
    }

    public static function deleteLangs($id)
    {
        self::where('id', $id)->delete();
    }

    public function translateUpdatedAt()
    {
        $translation = $this->transData()
            ->orderBy('updated_at')
            ->first();

        return $translation !== null ? $translation->updated_at->format('Y-m-d') : null;
    }
}
