<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskWorker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardWorkerController extends Controller
{
    public function index() {
        $user = Auth::user();
        $taskCount = TaskWorker::where('user_id', $user->id)->count();
        $privateTaskCount = Task::where('user_id', $user->id)->count();

        return view('pages.worker.dashboard', compact('user', 'taskCount', 'privateTaskCount'));
    }
}
