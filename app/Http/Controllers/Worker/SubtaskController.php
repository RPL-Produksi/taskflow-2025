<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\SubtaskWorker;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubtaskController extends Controller
{
    public function index(Task $task) {
        $user = Auth::user();
        $subtask = $task->subtask;

        return view('pages.worker.task.start-task', compact('user', 'task', 'subtask'));
    }

    public function progress(Request $request) {
        $request->validate([
            'subtask_id' => 'required',
        ]);

        $user = Auth::user();

        SubtaskWorker::create([
            'subtask_id' => $request->subtask_id,
            'user_id' => $user->id,
            'status' => 'in_progress',
        ]);

        return redirect()->back()->with('success', 'Subtask sudah dimulai');
    }

    public function ulang($id) {
        $subtaskWorker = SubtaskWorker::find($id);
        $data['status'] = 'in_progress';

        $subtaskWorker->update($data);
        return redirect()->back()->with('success', 'Subtask sudah dimulai');
    }

    public function review(Request $request, $id) {
        $data = $request->validate([
            'image' => 'nullable',
            'information' => 'nullable',
        ]);

        $subtaskWorker = SubtaskWorker::find($id);

        if($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('upload', 'public');
        } else {
            unset($data['image']);
        }

        $data['status'] = 'in_review';

        $subtaskWorker->update($data);
        return redirect()->back()->with('success', 'Bukti foto mu sudah dikirim ke tasker, silahkan tunggu validasi dari tasker');
    }
}
