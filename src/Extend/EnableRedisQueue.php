<?php

namespace Blomstra\Redis\Extend;

use Blomstra\Redis\Configuration;
use Blomstra\Redis\Provides\Queue;

/**
 * @deprecated Use \Blomstra\Redis\Extend\Redis instead
 */
class EnableRedisQueue extends RedisExtender
{
    protected $provide = Queue::class;
}
