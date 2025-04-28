<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrivateTaskController extends Controller
{
    public function index() {
        $user = Auth::user();
        $task = Task::where('user_id', $user->id)->get();

        return view('pages.worker.my-private-task.private-task', compact('user', 'task'));
    }

    public function add() {
        $user = Auth::user();

        return view('pages.worker.my-private-task.add', compact('user'));
    }

    public function edit($id) {
        $user = Auth::user();
        $task = Task::find($id);

        return view('pages.worker.my-private-task.edit', compact('user', 'task'));
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'image' => 'nullable'
        ]);

        $user = Auth::user();

        $path = null;
        if($request->hasFile('image')) {
            $path = $request->file('image')->store('image', 'public');
        }

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $path,
            'user_id' => $user->id,
        ]);

        return redirect()->route('private.task')->with('success', 'Task berhasil ditambahkan');
    }

    public function update(Request $request, $id) {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'image' => 'nullable'
        ]);

        $task = Task::find($id);

        if ($request->hasFile('image')) {
            $data['image'] = $path = $request->file('image')->store('image', 'public');
        } else {
            unset($data['image']);
        }

        $task->update($data);

        return redirect()->route('private.task')->with('success', 'Task berhasil diedit');
    }

    public function delete($id) {
        $task = Task::find($id);
        $task->delete();

        return redirect()->back()->with('success', 'Task berhasil dihapus');
    }
}
