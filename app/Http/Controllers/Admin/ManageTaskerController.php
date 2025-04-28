<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageTaskerController extends Controller
{
    public function index() {
        $user = Auth::user();
        $tasker = User::where('role', 'tasker')->get();

        return view('pages.admin.manage-tasker.manage-tasker', compact('user', 'tasker'));
    }

    public function dashboard() {
        $user = Auth::user();
        $taskerCount = User::where('role', 'tasker')->count();
        $workerCount = User::where('role', 'worker')->count();

        return view('pages.admin.dashboard', compact('user', 'taskerCount', 'workerCount'));
    }

    public function add() {
        $user = Auth::user();

        return view('pages.admin.manage-tasker.add-tasker', compact('user'));
    }

    public function edit($id) {
        $user = Auth::user();
        $tasker = User::find($id);

        return view('pages.admin.manage-tasker.edit-tasker', compact('user', 'tasker'));
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
            'role' => 'tasker',
        ]);

        return redirect()->route('manage.tasker')->with('success', 'Tasker berhasil ditambahkan');
    }

    public function update(Request $request, $id) {
        $data = $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'nullable',
            'avatar' => 'nullable'
        ]);

        $tasker = User::find($id);
        if ($request->filled('password')) {
            $tasker->password = bcrypt($request->password);
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatar', 'public');
        } else {
            unset($data['avatar']);
        }

        $tasker->update($data);
        return redirect()->route('manage.tasker')->with('success', 'Tasker berhasil diedit');
    }

    public function delete($id) {
        $tasker = User::find($id);
        $tasker->delete();

        return redirect()->back()->with('success', 'Tasker berhasil dihapus');
    }
}
