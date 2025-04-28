<?php

namespace App\Http\Controllers\Tasker;

use App\Http\Controllers\Controller;
use App\Models\SubtaskWorker;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManageTaskController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $task = Task::where('user_id', $user->id)
            ->with(['subtasks', 'taskWorkers', 'subtasks.subtaskWorkers'])
            ->get();

            $taskProgress = $task->map(function ($taskItem) {
                $statusCount = [
                    'pending' => 0,
                    'in_progress' => 0,
                    'in_review' => 0,
                    'done' => 0,
                    'rejected' => 0
                ];

                $totalSubtask = $taskItem->subtasks->count();
                $totalWorker = $taskItem->taskWorkers->count();

                $totalExpected = $totalSubtask * $totalWorker;

                foreach ($taskItem->subtasks as $subtask) {
                    foreach ($subtask->subtaskWorkers as $subtaskWorker) {
                        $statusCount[$subtaskWorker->status]++;
                    }
                }

                $alreadyWorked = array_sum($statusCount) - $statusCount['pending'];

                $statusCount['pending'] = $totalExpected - $alreadyWorked;

                $total = array_sum($statusCount);

                $statusPercent = [];
                foreach ($statusCount as $key => $value) {
                    $statusPercent[$key] = $total > 0 ? round(($value / $total) * 100, 1) : 0;
                }

                return [
                    'task' => $taskItem,
                    'statusCount' => $statusCount,
                    'statusPercent' => $statusPercent,
                ];
            });
        return view('pages.tasker.manage-task.manage-task', compact('user', 'task', 'taskProgress'));
    }

    public function add()
    {
        $user = Auth::user();
        return view('pages.tasker.manage-task.add-task', compact('user'));
    }

    public function edit($id)
    {
        $user = Auth::user();
        $task = Task::find($id);

        return view('pages.tasker.manage-task.edit-task', compact('user', 'task'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'image' => 'nullable',
            'video' => 'nullable'
        ]);

        $user = Auth::user();

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('image', 'public');
        }

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $path,
            'video' => $request->video,
            'user_id' => $user->id,
        ]);

        return redirect()->route('manage.task')->with('success', 'Task berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'video' => 'nullable',
            'image' => 'nullable'
        ]);

        $task = Task::find($id);

        if ($request->hasFile('image')) {
            $data['image'] = $path = $request->file('image')->store('image', 'public');
        } else {
            unset($data['image']);
        }

        $task->update($data);

        return redirect()->route('manage.task')->with('success', 'Task berhasil diedit');
    }

    public function delete($id)
    {
        $task = Task::find($id);
        $task->delete();

        return redirect()->back()->with('success', 'Task berhasil dihapus');
    }
}
