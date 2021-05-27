<?php

namespace Blomstra\Redis\Provides;

use Blomstra\Redis\Configuration;
use Blomstra\Redis\Manager;
use Blomstra\Redis\Overrides\RedisManager;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Redis\Factory;
use Illuminate\Queue\RedisQueue;

class Queue extends Provider
{
    private $connection = 'default';

    public function __invoke(Configuration $configuration, Container $container)
    {
        $container->resolving(Factory::class, function (RedisManager $manager) use ($configuration) {
            $manager->addConnection($this->connection, $configuration->toArray());
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
