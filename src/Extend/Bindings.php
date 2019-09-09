<?php

namespace Bokt\Redis\Extend;

use Bokt\Redis\Manager;
use Flarum\Extend\ExtenderInterface;
use Flarum\Extension\Extension;
use Illuminate\Contracts\Container\Container;

class Bindings implements ExtenderInterface
{
    public function extend(Container $container, Extension $extension = null)
    {
        $container->singleton(Manager::class, function ($app) {
            return new Manager($app, 'predis', []);
        });
    }
}
