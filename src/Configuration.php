<?php

namespace Blomstra\Redis;

use Blomstra\Redis\Provides\Cache;
use Blomstra\Redis\Provides\Queue;
use Blomstra\Redis\Provides\Session;
use Illuminate\Support\Arr;
use InvalidArgumentException;

class Configuration
{
    protected $config = [];
    protected $databases = [];
    protected $enabled = [
        'cache' => Cache::class,
        'queue' => Queue::class,
        'session' => Session::class
    ];

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
    public static function make($config): Configuration
    {
        if (is_string($config) && !file_exists($config)) {
            throw new InvalidArgumentException('Configuration does not exist');
        }

        $config = is_string($config) ? include $config : $config;

        return new static($config);
    }

    public function for(string $service): Configuration
    {
        $config = (array) $this->config;

        Arr::set(
            $config,
            'database',
            Arr::get($this->databases, $service, $config['database'])
        );

        return new Configuration($config);
    }

    public function toArray(): array
    {
        return (array) $config;
    }

    public function useDatabaseWith(string $service, int $database)
    {
        $this->databases[$service] = $database;

        return $this;
    }

    public function disable($service)
    {
        $service = (array) $service;

        Arr::forget($this->enabled, $service);

        return $this;
    }

    public function enabled(): array
    {
        return $this->enabled;
    }
}
