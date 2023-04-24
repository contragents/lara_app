<?php

namespace App\Providers;

use App\Managers\TestQueueManager;
use Illuminate\Queue\Events\JobQueued;
use Illuminate\Queue\Events\Looping;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            function (Looping $event) {
                Redis::connection()->del(
                    TestQueueManager::QUEUE_STATUS_KEY
                );
            }
        );

        Event::listen(
            function (JobQueued $event) {
                Redis::connection()->hset(
                    TestQueueManager::QUEUE_STATUS_KEY,
                    $event->id,
                    json_encode(['status' => 'Queued'])
                );
            }
        );

        Queue::before(
            function (JobProcessing $event) {
                Redis::connection()->hset(
                    TestQueueManager::QUEUE_STATUS_KEY,
                    $event->job->getJobId(),
                    json_encode(['status' => 'Processing'])
                );
            }
        );

        Queue::after(
            function (JobProcessed $event) {
                Redis::connection()->hdel(
                    TestQueueManager::QUEUE_STATUS_KEY,
                    $event->job->getJobId()
                );
            }
        );
    }
}
