<?php

namespace Bokt\Redis\Extend;

use Bokt\Redis\Configuration;
use Bokt\Redis\Provides\Queue;

/**
 * @mixin Configuration
 */
class EnableRedisQueue extends RedisExtender
{
    protected $provide = Queue::class;
}
