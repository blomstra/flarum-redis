<?php

namespace Bokt\Redis\Provides;

use Bokt\Redis\Configuration;
use Bokt\Redis\Manager;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Redis\Factory;
use Illuminate\Queue\RedisQueue;

class Queue extends Provider
{
    public function __invoke(Configuration $configuration, Container $container)
    {
        $container->resolving(Factory::class, function (Manager $manager) use ($configuration) {
            $manager->addConnection('default', $config = $configuration->toArray());
        });

        $container->bind('flarum.queue.connection', function ($app) {
            /** @var Manager $manager */
            $manager = $app->make(Factory::class);
            $queue = new RedisQueue($manager);
            $queue->setContainer($app);

            return $queue;
        });
    }
}
