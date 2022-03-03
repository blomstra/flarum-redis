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

namespace Blomstra\Redis\Overrides;

use Illuminate\Queue\RedisQueue as IlluminateQueue;

class RedisQueue extends IlluminateQueue
{
    /**
     * {@inheritdoc}
     */
    public function push($job, $data = '', $queue = null)
    {
        if ($job->queue && !$queue) {
            $queue = $job->queue;
        }

        parent::push($job, $data, $queue);
    }
}
