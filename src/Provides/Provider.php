<?php

namespace Blomstra\Redis\Provides;

use Blomstra\Redis\Configuration;
use Illuminate\Contracts\Container\Container;

abstract class Provider
{
    abstract public function __invoke(Configuration $configuration, Container $container);
}
