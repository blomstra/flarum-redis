<?php

namespace Blomstra\Redis\Provides;

use Blomstra\Redis\Configuration;
use Blomstra\Redis\Manager;
use Blomstra\Redis\Overrides\RedisManager;
use Illuminate\Cache\RedisStore;
use Illuminate\Cache\Repository;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Redis\Factory;
use Illuminate\Support\Arr;

class Cache extends Provider
{
    private string $connection = 'blomstra.cache';

    public function __invoke(Configuration $configuration, Container $container)
    {
        $container->resolving(Factory::class, function (RedisManager $manager) use ($configuration) {
            $manager->addConnection($this->connection, $configuration->toArray());
        });

        $container->bind('cache.redisstore', function ($container) use ($configuration) {
            /** @var RedisManager $manager */
            $manager = $container->make(RedisManager::class);

            return new RedisStore(
                $manager,
                Arr::get($configuration->toArray(), 'prefix', ''),
                $this->connection
            );
        });

        $container->extend('cache.store', function ($_, $container) use ($configuration) {
            return new Repository($container->make('cache.redisstore'));
        });

        $container->alias('cache.redisstore', Store::class);
    }
}
