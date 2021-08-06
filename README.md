# Redis sessions, cache & queues

This library allows using Redis as cache, session and for the queue. You can only 
enable these services by using a local extender (the `extend.php` in 
the root of your Flarum installation). See the "Set up" section below.

> This is an advanced utility for webmasters!

### Installation
Install manually with composer:

```sh
composer require blomstra/flarum-redis:*
```

### Set up

In your `extend.php`:

```php
return [
    new Blomstra\Redis\Extend\Redis([
        'host' => '127.0.0.1',
        'password' => null,
        'port' => 6379,
        'database' => 1
    ])
];
```

This enables sessions, cache and queue to run on redis.

> See "Use different database for each service" below to split up the database for cache vs sessions, queue
> because a cache clear action will clear sessions and queue jobs as well if they share the same database.

#### Advanced configuration

1. Disable specific services:

```php
return [
    (new Blomstra\Redis\Extend\Redis([
        'host' => '127.0.0.1',
        'password' => null,
        'port' => 6379,
        'database' => 1,
    ]))->disable(['cache', 'queue'])
];
```

2. Use different database for each service:

```php
return [
    (new Blomstra\Redis\Extend\Redis([
        'host' => '127.0.0.1',
        'password' => null,
        'port' => 6379,
        'database' => 1,
    ]))
    ->useDatabaseWith('cache', 1)
    ->useDatabaseWith('queue', 2)
    ->useDatabaseWith('session', 3)
];
```

3. Completely separate the config array:

```php
return [
    (new Blomstra\Redis\Extend\Redis([
        'connections' => [
            'cache' => [
              'host' => 'cache.int.yoursite.com',
              'password' => 'foo-bar',
              'port' => 6379,
              'database' => 1,
            ],
            'queue' => [
              'host' => 'queue.int.yoursite.com',
              'password' => 'foo-bar',
              'port' => 6379,
              'database' => 1,
            ],
            'session' => [
              'host' => 'session.int.yoursite.com',
              'password' => 'foo-bar',
              'port' => 6379,
              'database' => 1,
            ],
        ],
    ]))
];
```

4. Use a cluster:

```php
return [
    (new Blomstra\Redis\Extend\Redis([
        'host' => '127.0.0.1',
        'password' => null,
        'port' => 6379,
        'database' => 1,
        'options' => [
          'replication' => 'sentinel',
          'service' => 'mymaster:26379',
        ]
    ]))
    ->useDatabaseWith('cache', 1)
    ->useDatabaseWith('queue', 2)
    ->useDatabaseWith('session', 3)
];
```

#### Queue

Make sure to start your queue workers, see 
the [laravel documentation](https://laravel.com/docs/6.x/queues#running-the-queue-worker) for specifics. 
To test the worker can start use `php flarum queue:work`.

##### Queue options

The queue allows for several options to be added, retry_after, block_for and after_commit. You can set these
by adding a `queue` array in the configuration:

```php
return [
    (new Blomstra\Redis\Extend\Redis([
        'host' => '127.0.0.1',
        'password' => null,
        'port' => 6379,
        'database' => 1,
        'queue' => [
            'retry_after' => 120, // seconds
            'block_for' => 5, // seconds
            'after_commit' => true 
        ]       
    ]))
    ->useDatabaseWith('cache', 1)
    ->useDatabaseWith('queue', 2)
    ->useDatabaseWith('session', 3)
];
```

You can read up on the meaning of these options in the [Laravel Documentation](https://laravel.com/docs/8.x/queues#redis).

### Updating

```sh
composer update blomstra/flarum-redis
```

### FAQ

*Why are there still files in storage/cache?*
Some code still relies on physical files being present. This includes the formatter cache and the view caches.

### Links

- [Packagist](https://packagist.org/packages/blomstra/flarum-redis)
- [GitHub](https://github.com/blomstra/flarum-redis)

---

- Blomstra provides managed Flarum hosting.
- https://blomstra.net
- https://blomstra.community/t/ext-cache-assets
