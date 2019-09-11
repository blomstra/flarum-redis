<?php

namespace Bokt\Redis\Provides;

use Bokt\Redis\Configuration;
use Bokt\Redis\Manager;
use Illuminate\Contracts\Container\Container;
use Illuminate\Queue\RedisQueue;

class Queue extends Provider
{
    public function __invoke(Configuration $configuration, Container $container)
    {
        $container->bind('flarum.queue.connection', function ($app) use ($configuration) {

            /** @var Manager $manager */
            $manager = $app->make(Manager::class);

            $manager->addConnection('default', $config = $configuration->toArray());

            $queue = new RedisQueue($manager);
            $queue->setContainer($app);

            return $queue;
        });
    }
}
