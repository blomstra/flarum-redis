<?php

namespace Blomstra\Redis\Provides;

use Blomstra\Redis\Configuration;
use Blomstra\Redis\Overrides\RedisManager;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Redis\Factory;
use Illuminate\Queue\RedisQueue;
use Illuminate\Support\Arr;

class Queue extends Provider
{
    private $connection = 'default';

    public function __invoke(Configuration $configuration, Container $container)
    {
        $container->resolving(Factory::class, function (RedisManager $manager) use ($configuration) {
            $config = $configuration->toArray();

            // Queue does not like clusters, force the master connection:
            if (Arr::get($config, 'options.replication') && $service = Arr::get($config, 'options.service')) {
                $manager->addConnection($this->connection, $service);
            } else {
                $manager->addConnection($this->connection, $configuration->toArray());
            }
        });

        $container->bind('flarum.queue.connection', function ($container) {
            /** @var RedisManager $manager */
            $manager = $container->make(Factory::class);

            $queue = new RedisQueue($manager, $this->connection);
            $queue->setContainer($container);

            return $queue;
        });
    }
}
