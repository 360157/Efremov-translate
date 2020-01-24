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
    public static function redisDelete($patern)
    {
        Redis::pipeline(function ($pipe) use ($patern)  {
            foreach (Redis::keys($patern) as $key) {
                $pipe->del($key);
            }
        });
    }

    public static function redisDeleteByGroup($type, $group)
    {
        self::redisDelete($type.':'.$group.':*:*');
    }

    public static function redisSet($type, $group, $key, $lang, $translation)
    {
        Redis::set($type.':'.$group.':'.$key.':'.$lang, $translation);
    }
}