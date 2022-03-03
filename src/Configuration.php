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
        'cache'   => Cache::class,
        'queue'   => Queue::class,
        'session' => Session::class,
    ];

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * Set Redis configuration from file or by providing a configuration array.
     *
     * @param string|array $config
     *
     * @return $this
     */
    public static function make($config): Configuration
    {
        if (is_string($config) && !file_exists($config)) {
            throw new InvalidArgumentException('Configuration file does not exist');
        }

        if (!is_string($config) && !is_array($config)) {
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

        if (empty($config['password'])) {
            Arr::forget($config, 'password');
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
