<?php

namespace Blomstra\Redis;

use InvalidArgumentException;

class Configuration
{
    protected $config = [];

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * Set Redis configuration from file or by providing a configuration array.
     *
     * @param string|array $config
     * @return $this
     */
    public function useConfig($config)
    {
        if (is_string($config) && !file_exists($config)) {
            throw new InvalidArgumentException('Configuration does not exist');
        }

        $this->config = is_string($config) ? include $config : $config;

        return $this;
    }

    public function toArray(): array
    {
        return (array) $this->config;
    }
}
