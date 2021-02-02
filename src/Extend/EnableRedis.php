<?php

namespace Blomstra\Redis\Extend;

use Blomstra\Redis\Extend\EnableRedisCache;
use Blomstra\Redis\Extend\EnableRedisQueue;
use Flarum\Extend\ExtenderInterface;
use Flarum\Extension\Extension;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Arr;

class EnableRedis implements ExtenderInterface
{
    private $config;

    public function __construct(array $config = null)
    {
        $this->config = $config;
    }

    public function extend(Container $container, Extension $extension = null)
    {
        if (!empty($this->config) && Arr::get($this->config, 'host')) {

            /** @var SettingsRepositoryInterface */
            $settings = app(SettingsRepositoryInterface::class);

            if ((bool) $settings->get('blomstra-redis.enableCache', false)) {
                (new EnableRedisCache($this->config))->extend($container, $extension);
            }
            
            if ((bool) $settings->get('blomstra-redis.enableQueue', false)) {
                (new EnableRedisQueue($this->config))->extend($container, $extension);
            }

            if ((bool) $settings->get('blomstra-redis.redisSessions', false)) {
                (new OverrideSessionHandler($this->config))->extend($container, $extension);
            }
        }
    }
}
