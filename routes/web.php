<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('queue_status');//view('welcome');
});

Route::get('/queue_status', [Controller::class, 'queue_status'])->name('queue_status');

Route::get('/run_job/{taskId}', [Controller::class, 'run_job'])->name('run_job');
