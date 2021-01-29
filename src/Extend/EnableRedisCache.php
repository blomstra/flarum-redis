<?php

namespace Blomstra\Redis\Extend;

use Blomstra\Redis\Configuration;
use Blomstra\Redis\Provides\Cache;

/**
 * @mixin Configuration
 */
class EnableRedisCache extends RedisExtender
{
    protected $provide = Cache::class;
}
