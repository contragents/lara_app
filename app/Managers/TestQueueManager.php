<?php

namespace App\Managers;

use App\Jobs\TestJob;
use App\Jobs\TestJob2;
use Illuminate\Support\Facades\Redis;

class TestQueueManager
{
    const QUEUE_STATUS_KEY = 'queue_status';
    const JOB_CLASSES = [126 => TestJob::class, 542 => TestJob2::class];
    const QUEUE_EVENTS = [
        'Queued' => 'Queued',
        'Processing' => 'Processing',
        'Processed' => 'Processed',
        'Looping' => 'Looping'
    ];

    public static function getQueueStatus()
    {
        $queueStatus = Redis::connection()->hgetall(self::QUEUE_STATUS_KEY);

        foreach ($queueStatus as $jobId => $jobStatus) {
            $queueStatus[$jobId] = json_decode($jobStatus, true);
        }

        return $queueStatus;
    }

    public static function registerQueueEvent(string $eventName, string $jobId = '')
    {
        if (!in_array($eventName, self::QUEUE_EVENTS)) {
            return;
        }

        if ($eventName == self::QUEUE_EVENTS['Looping']) {
            self::clearQueueStats();
        } elseif ($jobId) {
            Redis::connection()->hset(
                self::QUEUE_STATUS_KEY,
                $jobId,
                json_encode(['status' => $eventName])
            );
        }
    }

    public static function runJob($taskId)
    {
        if (isset(self::JOB_CLASSES[$taskId])) {
            $jobClass = self::JOB_CLASSES[$taskId];
            $jobClass::dispatch(['value' => $taskId]);

            return 'Job dispatched!';
        } else {
            return 'Job is not registered!';
        }
    }

    private static function clearQueueStats()
    {
        Redis::connection()->del(self::QUEUE_STATUS_KEY);
    }
}