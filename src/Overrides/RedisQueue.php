<?php

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
