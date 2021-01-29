<?php

namespace Blomstra\Redis\Extend;

use Blomstra\Redis\Configuration;
use Blomstra\Redis\Provides\Queue;

/**
 * @mixin Configuration
 */
class EnableRedisQueue extends RedisExtender
{
    protected $provide = Queue::class;
}
