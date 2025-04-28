<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\TaskWorker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index() {
        $user = Auth::user();
        $task = TaskWorker::where('user_id', $user->id)->with('task')->with('user')->get();

        return view('pages.worker.task.task', compact('user', 'task'));
    }
}
