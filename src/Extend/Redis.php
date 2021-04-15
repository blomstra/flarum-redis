<?php

namespace Blomstra\Redis\Extend;

use Blomstra\Redis\Configuration;
use Flarum\Extend\ExtenderInterface;
use Flarum\Extension\Extension;
use Illuminate\Contracts\Container\Container;

/**
 * @mixin Configuration
 */
class Redis implements ExtenderInterface
{
    /**
     * @var array|string $config
     */
    public function __construct($config)
    {
        $this->configuration = Configuration::make($config);
    }

    public function extend(Container $container, Extension $extension = null)
    {
        $services = $this->configuration->enabled();

        // Add bindings only if any of the redis services are requested.
        if (count($services)) {
            (new Bindings)->extend($container, $extension);
        }

        foreach ($services as $service => $class) {
            (new $class)(
                $this->configuration->for($service),
                $container
            );
        }

    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->configuration, $name], $arguments);
    }
}
