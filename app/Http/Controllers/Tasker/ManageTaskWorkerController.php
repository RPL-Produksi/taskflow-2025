<?php

namespace App\Http\Controllers\Tasker;

use App\Http\Controllers\Controller;
use App\Models\SubtaskWorker;
use App\Models\Task;
use App\Models\TaskWorker;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageTaskWorkerController extends Controller
{
    public function index(Task $task) {
        $user = Auth::user();
        $taskWorker = TaskWorker::where('task_id', $task->id)->with('user')->get();
        $worker = User::where('role', 'worker')->get();

        return view('pages.tasker.manage-worker.manage-worker', compact('user', 'taskWorker', 'task', 'worker'));
    }

    public function store(Request $request) {
        $request->validate([
            'user_id' => 'required',
            'task_id' => 'required'
        ]);

        $exist = TaskWorker::where('user_id', $request->user_id)->where('task_id', $request->task_id)->exists();
        if($exist) {
            return redirect()->back()->with('error', 'Worker sudah ada');
        }

        TaskWorker::create([
            'user_id' => $request->user_id,
            'task_id' => $request->task_id,
        ]);

        return redirect()->back()->with('success', 'Worker berhasil ditambahkan');
    }

    public function delete($id) {
        $worker = TaskWorker::find($id);
        $worker->delete();

        return redirect()->back()->with('success', 'Worker berhasil dihapus di task ini');
    }
}
