<?php

namespace App\Http\Controllers\Tasker;

use App\Http\Controllers\Controller;
use App\Models\SubtaskWorker;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageSubtaskWorkerController extends Controller
{
    public function index(Task $task, User $worker) {
        $user = Auth::user();
        $subtask = $task->subtask;

        return view('pages.tasker.manage-worker.view-worker', compact('user', 'task', 'worker', 'subtask'));
    }

    public function acc(Request $request, $id) {
        $data = $request->validate([
            'comment' => 'nullable',
        ]);

        $subtaskWorker = SubtaskWorker::find($id);
        $data['status'] = 'done';

        $subtaskWorker->update($data);
        return redirect()->back()->with('success', 'Subtask berhasil di acc');
    }

    public function cancel(Request $request, $id) {
        $data = $request->validate([
            'comment' => 'nullable',
        ]);

        $subtaskWorker = SubtaskWorker::find($id);
        $data['status'] = 'rejected';

        $subtaskWorker->update($data);
        return redirect()->back()->with('success', 'Subtask berhasil di reject');
    }
}
