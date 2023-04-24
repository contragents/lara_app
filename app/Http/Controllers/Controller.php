<?php

namespace App\Http\Controllers;

use App\Managers\TestQueueManager;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function queue_status()
    {
        return view('queue_status', ["data" => \App\Managers\TestQueueManager::getQueueStatus()]);
    }

    public function run_job($taskId)
    {
        print TestQueueManager::runJob($taskId);
    }
}
