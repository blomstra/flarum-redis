<?php

namespace Bokt\Redis\Extend;

use Bokt\Redis\Overrides\RedisManager;
use Flarum\Extend\ExtenderInterface;
use Flarum\Extension\Extension;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Redis\Factory;

class Bindings implements ExtenderInterface
{
    protected static $bound = false;

    public function extend(Container $container, Extension $extension = null)
    {
        if (static::$bound === false) {
            $container->singleton(RedisManager::class, function ($app) {
                return new RedisManager($app, 'predis', []);
            });

            $container->alias(RedisManager::class, Factory::class);

            static::$bound = true;
        }
    }
}
