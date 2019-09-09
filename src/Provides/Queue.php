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

            $manager->addConnection('queue', $config = $configuration->toArray());

            return new RedisQueue(
                $manager,
                'default',
                'queue'
            );
        });
    }
}
