<?php

/*
 * This file is part of blomstra/flarum-redis.
 *
 * Copyright (c) Bokt.
 * Copyright (c) Blomstra Ltd.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

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
    protected $configuration;

    /**
     * @var array|string
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
            (new Bindings())->extend($container, $extension);
        }

        foreach ($services as $service => $class) {
            (new $class())(
                $this->configuration->for($service),
                $container
            );
        }
    }

    public function __call($name, $arguments)
    {
        $forwarded = call_user_func_array([$this->configuration, $name], $arguments);

        // Allows chaining from the extend.php so that it doesnt return the Configuration
        if ($forwarded instanceof Configuration) {
            return $this;
        }
    }
}
