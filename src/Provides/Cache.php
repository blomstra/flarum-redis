<?php

namespace Bokt\Redis\Provides;

use Bokt\Redis\Configuration;
use Bokt\Redis\Manager;
use Illuminate\Cache\RedisStore;
use Illuminate\Cache\Repository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Arr;

class Cache extends Provider
{
    public function __invoke(Configuration $configuration, Container $container)
    {
        $container->bind('cache.store', function ($app) use ($configuration) {
            /** @var Manager $manager */
            $manager = $app->make(Manager::class);

            $manager->addConnection('cache', $config = $configuration->toArray());

            $store = new RedisStore(
                $manager,
                Arr::get($config, 'prefix', ''),
                'cache'
            );

            return new Repository($store);
        });
    }
}
