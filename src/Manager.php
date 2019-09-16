<?php

namespace Bokt\Redis;

use Illuminate\Redis\RedisManager;

class Manager extends RedisManager
{
    public function addConnection(string $name, array $config)
    {
        $this->config[$name] = $config;

        return $this;
    }

    public function getConnectionConfig(string $name = 'default'): ?array
    {
        return $this->config[$name] ?? null;
    }
}
