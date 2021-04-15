<?php

namespace Blomstra\Redis\Provides;

use Blomstra\Redis\Configuration;
use Blomstra\Redis\Manager;
use Blomstra\Redis\Overrides\RedisManager;
use Flarum\Extend\Frontend;
use Flarum\Extension\ExtensionManager;
use Flarum\Frontend\Document;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Redis\Factory;
use Illuminate\Queue\Events\Looping;
use Illuminate\Queue\RedisQueue;
use Illuminate\Contracts\Queue\Queue as QueueContract;

class Session extends Provider
{
    private $connection = 'blomstra.sessions';

    public function __invoke(Configuration $configuration, Container $container)
    {
        $container->resolving(Factory::class, function (RedisManager $manager) use ($configuration) {
            $manager->addConnection($this->connection, $configuration->toArray());
        });

        $container->singleton('session.redisstore', function ($container) use ($configuration) {
            /** @var RedisManager $manager */
            $manager = $container->make(RedisManager::class);

            return new RedisStore(
                $manager,
                Arr::get($config->toArray(), 'prefix', ''),
                $this->connection
            );
        });

        $container->extend('session.handler', function () {
            $config = $container->make(Repository::class);

            return new RedisSessionHandler(
                new CacheRepository($container->make('session.redisstore')),
                $config['session.lifetime'],
            );
        });

        $container->alias('session.handler', SessionHandlerInterface::class);
    }
}
