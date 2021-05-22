<?php

namespace Blomstra\Redis\Session;

use Illuminate\Session\CacheBasedSessionHandler;

class RedisSessionHandler extends CacheBasedSessionHandler
{
    public function __sleep(): array
    {
        return ['minutes'];
    }

    public function __wakeup(): void
    {
        $this->cache = resolve('cache.store');
    }
}
