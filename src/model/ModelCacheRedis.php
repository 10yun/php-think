<?php

namespace shiyun\model;

use shiyun\extend\RedisCache;

/**
 * model数据加缓存
 */
class ModelCacheRedis extends RedisCache
{
    protected static $instances = [];
    public static function getInstance()
    {
        $class = get_called_class();
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new static();
        }
        return self::$instances[$class];
    }
}
