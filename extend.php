<?php

namespace Blomstra\Redis;

use Blomstra\Redis\Extend\EnableRedis;
use Flarum\Extend;

$redisConfig = [
	'host' => getenv('REDIS_HOST'),
	'password' => getenv('REDIS_PASSWORD') ? getenv('REDIS_PASSWORD') : null,
	'port' => getenv('REDIS_PORT'),
	'database' => getenv('REDIS_DATABASE'),
];

return [
    (new Extend\Frontend('admin'))
		->js(__DIR__.'/js/dist/admin.js'),

	new Extend\Locales(__DIR__.'/resources/locale'),

	(new EnableRedis($redisConfig)),
];
