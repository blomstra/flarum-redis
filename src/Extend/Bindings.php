<?php

namespace Bokt\Redis\Extend;

use Bokt\Redis\Manager;
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
            $container->singleton(Manager::class, function ($app) {
                return new Manager($app, 'predis', []);
            });

            $container->alias(Manager::class, Factory::class);

            static::$bound = true;
        }
    }
}
