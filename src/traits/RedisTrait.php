<?php
/**
 * Created by PhpStorm.
 * User: ipeople
 * Date: 04.09.19
 * Time: 16:01
 */

namespace Sashaef\TranslateProvider\Traits;

use Illuminate\Support\Facades\Redis;

trait RedisTrait
{
    public static function redisDelete($key)
    {
        foreach (Redis::keys($key) as $key) {
            Redis::del($key);
        }
    }

    public static function redisDeleteByGroup($type, $group)
    {
        foreach (Redis::keys($type.':'.$group.':*:*') as $key) {
            Redis::del($key);
        }
    }

    public static function redisSet($type, $group, $key, $lang, $translation)
    {
        Redis::set($type.':'.$group.':'.$key.':'.$lang, $translation);
    }
}