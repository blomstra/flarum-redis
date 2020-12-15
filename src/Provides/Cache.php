<?php

namespace Bokt\Redis\Provides;

use Bokt\Redis\Configuration;
use Bokt\Redis\Manager;
use Bokt\Redis\Overrides\RedisManager;
use Illuminate\Cache\RedisStore;
use Illuminate\Cache\Repository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Redis\Factory;
use Illuminate\Support\Arr;

class Cache extends Provider
{
    private $connection = 'bokt.cache';

    public function __invoke(Configuration $configuration, Container $container)
    {
        $container->resolving(Factory::class, function (RedisManager $manager) use ($configuration) {
            $manager->addConnection($this->connection, $configuration->toArray());
        });

        $container->bind('cache.store', function ($app) use ($configuration) {
            /** @var Manager $manager */
            $manager = $app->make(Manager::class);

            $store = new RedisStore(
                $manager,
                Arr::get($configuration->toArray(), 'prefix', ''),
                $this->connection
            );

            return new Repository($store);
        });
    }
}
