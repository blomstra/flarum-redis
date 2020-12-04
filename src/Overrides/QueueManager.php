<?php /** @noinspection PhpHierarchyChecksInspection */

namespace Bokt\Redis\Overrides;

class QueueManager extends \Illuminate\Queue\QueueManager
{
    public function addConnection(string $name, array $config)
    {
        $this->config[$name] = $config;

        return $this;
    }
}
