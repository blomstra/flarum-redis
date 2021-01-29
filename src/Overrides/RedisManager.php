<?php /** @noinspection PhpHierarchyChecksInspection */

namespace Blomstra\Redis\Overrides;

use Illuminate\Redis\RedisManager as IlluminateManager;

class RedisManager extends IlluminateManager
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
