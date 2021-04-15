<?php

namespace Blomstra\Redis\Extend;

use Blomstra\Redis\Configuration;
use Blomstra\Redis\Provides\Cache;

/**
 * @deprecated Use \Blomstra\Redis\Extend\Redis instead
 */
class EnableRedisCache extends RedisExtender
{
    protected $provide = Cache::class;
}
