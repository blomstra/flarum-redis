<?php

namespace Blomstra\Redis;

use Blomstra\Redis\Provides\Cache;
use Blomstra\Redis\Provides\Queue;
use Blomstra\Redis\Provides\Session;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
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
            throw new InvalidArgumentException('Configuration file does not exist');
        }

        if (! is_string($config) && ! is_array($config)) {
            throw new InvalidArgumentException('Configuration must be either a path or an array.');
        }

        $config = is_string($config) ? include $config : $config;

        return new static($config);
    }

    public function for(string $service): Configuration
    {
        $config = $this->config;

        // In case the configuration contains a `connections` key, we'll use that.
        if ($connection = Arr::get($config, "connections.$service")) {
            $config = $connection;
        }

        $useDatabase = Arr::get($this->databases, $service, $config['database'] ?? 0);

        // Override the database if `useDatabaseWith` was called.
        Arr::set(
            $config,
            'database',
            $useDatabase
        );

        if (Arr::get($config, 'options.replication')
            && ! Str::contains(Arr::get($config, 'options.service', '/'), '/')
            && $service = Arr::get($config, 'options.service')) {

            Arr::set($config, 'options.service', "tcp://$service?alias=master");
            Arr::set($config, 'options.parameters', [
                'password' => Arr::get($config, 'password'),
                'database' => $useDatabase
            ]);
        }

        return new Configuration($config);
    }

    public function toArray(): array
    {
        return $this->config;
    }

    public function useDatabaseWith(string $service, int $database): Configuration
    {
        $this->databases[$service] = $database;

        return $this;
    }

    public function disable($service): Configuration
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
