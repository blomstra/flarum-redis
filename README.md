# Redis cache and queue

This extension allows switching the Flarum native file cache and sync queue with
a redis based cache and queue.

## Installation

Use Bazaar or install using composer:

```bash
$ composer require bokt/flarum-redis
```

After that enable the extension in your admin area.

## Configuration

In your local `extend.php` you need to decide what you want to use:

```php
return [
    new Bokt\Redis\Extend\EnableRedisCache($config = [
        'url' => env('REDIS_URL'),
        'host' => env('REDIS_HOST', '127.0.0.1'),
        'password' => env('REDIS_PASSWORD', null),
        'port' => env('REDIS_PORT', 6379),
        'database' => env('REDIS_CACHE_DB', 1),
    ]),
    new Bokt\Redis\Extend\EnableRedisQueue($config),
];
```

You can use different configs for cache and queue. But you can also
point at a file:

```php
return [
    new Bokt\Redis\Extend\EnableRedisCache('cache.php'),
    new Bokt\Redis\Extend\EnableRedisQueue('queue.php'),
];
```
Make sure the file returns an array containing the configuration.
