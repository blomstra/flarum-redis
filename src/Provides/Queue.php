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
        $container->resolving(Factory::class, function (Factory $manager) use ($configuration) {
            $manager->addConnection($this->connection, $configuration->toArray());
        });

        $container->bind('flarum.queue.connection', function ($container) use ($configuration) {
            $config = Arr::get($configuration->toArray(), 'queue', []);

            /** @var RedisManager $manager */
            $manager = $container->make(Factory::class);

            $queue = new RedisQueue(
                $manager,
                'default',
                $this->connection,
                Arr::get($config, 'retry_after', 60),
                Arr::get($config, 'block_for', 1),
                Arr::get($config, 'after_commit', false)
            );
            $queue->setContainer($container);

            return $queue;
        });
    }
}
