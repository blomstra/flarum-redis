<?php

namespace Blomstra\Redis\Extend;

use Blomstra\Redis\Configuration;
use Flarum\Extend\ExtenderInterface;
use Flarum\Extension\Extension;
use Illuminate\Contracts\Container\Container;

/**
 * @deprecated Use \Blomstra\Redis\Extend\Redis instead
 */
abstract class RedisExtender implements ExtenderInterface
{
    protected $provide;
    protected $configuration;

    public function __construct(array $config = null)
    {
        $this->configuration = new Configuration($config);
    }

    public function extend(Container $container, Extension $extension = null)
    {
        (new Bindings)->extend($container, $extension);
        (new $this->provide())($this->configuration, $container);
    }
}
