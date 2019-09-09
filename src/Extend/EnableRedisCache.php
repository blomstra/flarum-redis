<?php

namespace Bokt\Redis\Extend;

use Bokt\Redis\Configuration;
use Bokt\Redis\Provides\Cache;

/**
 * @mixin Configuration
 */
class EnableRedisCache extends RedisExtender
{
    protected $provide = Cache::class;
}
