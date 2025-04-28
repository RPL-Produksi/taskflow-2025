<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index() {
        return view('pages.auth.login');
    }

    public function register() {
        return view('pages.auth.register');
    }

    public function profile() {
        $user = Auth::user();

        return view('pages.auth.profile', compact('user'));
    }

    public function login(Request $request) {
        $data = $request->only('username', 'password');

        if(Auth::attempt($data)) {
            $user = Auth::user();

            if ($user->role == 'admin') {
                return redirect()->route('dashboard.admin')->with('success', 'Anda berhasil login');
            } elseif ($user->role == 'tasker') {
                return redirect()->route('dashboard.tasker')->with('success', 'Anda berhasil login');
            } elseif ($user->role == 'worker') {
                return redirect()->route('dashboard.worker')->with('success', 'Anda berhasil login');
            }
        }
        return redirect()->back()->with('error', 'Username atau password salah');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('index')->with('success', 'Anda berhasil logout');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => 'worker',
        ]);

        return redirect()->route('index')->with('success', 'Berhasil daftar, login sekarang');
    }

    public function update(Request $request, $id) {
        $data = $request->validate([
            'name' => 'nullable',
            'username' => 'nullable',
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
        return redirect()->back()->with('success', 'Profile berhasil diedit');
    }
}
