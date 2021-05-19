# Redis cache, queues & sessions

This extension allows using Redis as cache, queue or for the sessions. You can enable these by using a local extender (the `extend.php` in the root of your Flarum installation), or by using the toggle switches provided in the admin panel. See the configuring section below.

> This is an advanced extension for webmasters able to configure redis and the queue workers.

### Installation
Install manually with composer:

```sh
composer require blomstra/flarum-redis
```

#### Configuration with environment variables

The simplest way to create your Redis configuration is by setting the following environment variables:

- `REDIS_HOST`
- `REDIS_PASSWORD` (usually `null`)
- `REDIS_PORT`
- `REDIS_DATABASE`

If you omit the extenders below, you may toggle each feature on/off via the admin panel. Using one or more of the extenders will override the state in the admin panel.
#### Configuring cache

In your `extend.php`:

```php

return [
    new Blomstra\Redis\Extend\EnableRedisCache([
        'host' => '127.0.0.1',
        'password' => null,
        'port' => 6379,
        'database' => 1,
    ]),
];
```

This will immediately override the Flarum cache to use redis.

#### Configuring queue

In your `extend.php`:

```php
return [
    new Blomstra\Redis\Extend\EnableRedisQueue([
        'host' => '127.0.0.1',
        'password' => null,
        'port' => 6379,
        'database' => 1,
    ]),
];
```

Make sure to start your queue workers, see the [laravel documentation](https://laravel.com/docs/8.x/queues#running-the-queue-worker) for specifics. To test the worker can start use `php flarum queue:work`.

If you choose to enable the queue a load counter will show up on the admin dashboard for all queues used in your queue workers.

### Updating

```sh
composer update blomstra/flarum-redis
```

### Links

- [Packagist](https://packagist.org/packages/blomstra/flarum-redis)
- [GitHub](https://github.com/blomstra/flarum-redis)

### Disclaimer

This extension is developed as an employee of @BartVB at Bokt. Bokt is the largest equine community in the Netherlands. We're currently moving a phpBB forum with over 100 million posts to Flarum. By keeping both in sync until we're more feature complete, we offer our users a slow transition to this fantastic new platform.

### Simplify the extend

You can combine the configuration array if you use both cache and queue:

```php
return [
    new Blomstra\Redis\Extend\EnableRedisCache($config = [
        'host' => '127.0.0.1',
        'password' => null,
        'port' => 6379,
        'database' => 1,
    ]),
    new Blomstra\Redis\Extend\EnableRedisQueue($config),
    new Blomstra\Redis\Extend\OverrideSessionHandler($config),
];
```

### Complex configuration

The configuration used is identical to the one used in Laravel, check the Laravel redis configuration for more information if you need to do some finetuning.
