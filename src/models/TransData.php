<?php

namespace Sashaef\TranslateProvider\Models;

use Illuminate\Database\Eloquent\Model;

class TransData extends Model
{
    protected $table = 'trans_data';

    protected $fillable = ['translation_id', 'lang_id', 'status'];

    public function trans()
    {
        return $this->belongsTo(Trans::class);
    }

    public function lang()
    {
        return $this->belongsTo(Langs::class);
    }

    public static function postTransData($trans_id, $lang_id, $status)
    {
        return self::create([
            'translation_id' => $trans_id,
            'lang_id' => $lang_id,
            'status' => $status
        ]);
    }

    public static function updateStatus($id, $status)
    {
        return self::where('id', $id)->update([
            'status' => $status
        ]);
    }
}
