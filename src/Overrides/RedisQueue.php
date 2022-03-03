<?php

namespace Blomstra\Redis\Overrides;

use Illuminate\Queue\RedisQueue as IlluminateQueue;

class RedisQueue extends IlluminateQueue
{
    /**
     * Push a new job onto the queue.
     *
     * @param  object|string  $job
     * @param  mixed  $data
     * @param  string|null  $queue
     * @return mixed
     */
    public function push($job, $data = '', $queue = null)
    {
        if ($job->queue && !$queue) {
            $queue = $job->queue;
        }

        return $this->enqueueUsing(
            $job,
            $this->createPayload($job, $this->getQueue($queue), $data),
            $queue,
            null,
            function ($payload, $queue) {
                return $this->pushRaw($payload, $queue);
            }
        );
    }
}
