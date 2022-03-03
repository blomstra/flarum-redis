<?php

/*
 * This file is part of blomstra/flarum-redis.
 *
 * Copyright (c) Bokt.
 * Copyright (c) Blomstra Ltd.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Blomstra\Redis\Overrides;

use Illuminate\Redis\RedisManager as IlluminateManager;
use Illuminate\Support\Arr;

class RedisManager extends IlluminateManager
{
    public function addConnection(string $name, array $config)
    {
        if (Arr::get($config, 'options.replication')) {
            $this->config['clusters'][$name] = [$config];
        } else {
            $this->config[$name] = $config;
        }

        return $this;
    }

    public function getConnectionConfig(string $name = 'default'): ?array
    {
        return $this->config[$name] ?? $this->config['clusters'][$name] ?? null;
    }
}
