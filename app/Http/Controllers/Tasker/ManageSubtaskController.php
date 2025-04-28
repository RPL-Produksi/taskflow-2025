<?php

namespace App\Http\Controllers\Tasker;

use App\Http\Controllers\Controller;
use App\Models\Subtask;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageSubtaskController extends Controller
{
    public function index(Task $task) {
        $user = Auth::user();
        $subtask = Subtask::where('task_id', $task->id)->get();

        return view('pages.tasker.manage-subtask.manage-subtask', compact('user', 'task', 'subtask'));
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'task_id' => 'required'
        ]);

        Subtask::create([
            'title' => $request->title,
            'task_id' => $request->task_id,
        ]);

        return redirect()->back()->with('success', 'Subtask berhasil ditambahkan');
    }

    public function delete($id) {
        $subtask = Subtask::find($id);
        $subtask->delete();

        return redirect()->back()->with('success', 'Subtask berhasil dihapus');
    }
}
