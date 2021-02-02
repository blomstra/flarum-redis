<?php

namespace Blomstra\Redis\Extend;

use Flarum\Extend\ExtenderInterface;
use Flarum\Extension\Extension;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\RedisSessionHandler;

class OverrideSessionHandler implements ExtenderInterface
{
    public $cache;

    private ?array $config;

    public function __construct(array $config = null)
    {
        $this->config = $config;
    }

    private function createRedisObject()
    {
        $this->cache = new \Predis\Client($this->config);
        $this->cache->connect();
    }
    
    public function extend(Container $container, Extension $extension = null)
    {
        $this->createRedisObject();

        $container->extend('session.handler', function ($_, $container) {
            $rsh = new RedisSessionHandler(
                $this->cache,
                [
                    'prefix' => 'flarum_',
                ]
            );

            $rsh->open(null, 'flarum_redis');

            return $rsh;
        });

        $container->alias('session.handler', SessionHandlerInterface::class);
    }
}
