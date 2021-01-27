<?php

namespace Bokt\Redis\Extend;

use Bokt\Redis\Overrides\RedisManager;
use Flarum\Extend\ExtenderInterface;
use Flarum\Extension\Extension;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Redis\Factory;

class Bindings implements ExtenderInterface
{
    public function extend(Container $container, Extension $extension = null)
    {
        if (! $container->has(RedisManager::class)) {
            $container->singleton(RedisManager::class, function ($app) {
                return new RedisManager($app, 'predis', []);
            });

            $container->alias(RedisManager::class, Factory::class);
        }
    }
}
