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
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Cleaning statistics on queue looping
        Event::listen(
            function (Looping $event) {
                TestQueueManager::registerQueueEvent(TestQueueManager::QUEUE_EVENTS['Looping']);
            }
        );

        // Job queued event
        Event::listen(
            function (JobQueued $event) {
                TestQueueManager::registerQueueEvent(TestQueueManager::QUEUE_EVENTS['Queued'], $event->id);
            }
        );

        // Job processing event
        Queue::before(
            function (JobProcessing $event) {
                TestQueueManager::registerQueueEvent(
                    TestQueueManager::QUEUE_EVENTS['Processing'],
                    $event->job->getJobId()
                );
            }
        );

        // Job processed event
        Queue::after(
            function (JobProcessed $event) {
                TestQueueManager::registerQueueEvent(
                    TestQueueManager::QUEUE_EVENTS['Processed'],
                    $event->job->getJobId()
                );
            }
        );
    }
}
