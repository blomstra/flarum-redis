<?php /** @noinspection PhpHierarchyChecksInspection */

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
