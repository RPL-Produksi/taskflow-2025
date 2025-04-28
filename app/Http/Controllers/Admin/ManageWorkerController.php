<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageWorkerController extends Controller
{
    public function index() {
        $user = Auth::user();
        $worker = User::where('role', 'worker')->get();

        return view('pages.admin.manage-worker.manage-worker', compact('user', 'worker'));
    }

    public function add() {
        $user = Auth::user();

        return view('pages.admin.manage-worker.add-worker', compact('user'));
    }

    public function edit($id) {
        $user = Auth::user();
        $worker = User::find($id);

        return view('pages.admin.manage-worker.edit-worker', compact('user', 'worker'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'avatar' => 'nullable'
        ]);

        $path = null;
        if($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatar', 'public');
        }

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'avatar' => $path,
            'role' => 'worker',
        ]);

        return redirect()->route('manage.worker')->with('success', 'Worker berhasil ditambahkan');
    }

    public function update(Request $request, $id) {
        $data = $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'nullable',
            'avatar' => 'nullable'
        ]);

        $worker = User::find($id);
        if ($request->filled('password')) {
            $worker->password = bcrypt($request->password);
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatar', 'public');
        } else {
            unset($data['avatar']);
        }

        $worker->update($data);
        return redirect()->route('manage.worker')->with('success', 'Worker berhasil diedit');
    }

    public function delete($id) {
        $worker = User::find($id);
        $worker->delete();

        return redirect()->back()->with('success', 'Worker berhasil dihapus');
    }
}
