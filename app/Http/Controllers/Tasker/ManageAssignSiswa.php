<?php

namespace App\Http\Controllers\Tasker;

use App\Http\Controllers\Controller;
use App\Models\Tes;
use App\Models\TesSiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageAssignSiswa extends Controller
{
    public function index(Tes $tes)
    {
        $user = Auth::user();
        $tesSiswa = TesSiswa::where('tes_id', $tes->id)->with('user')->get();
        $worker = User::where('role', 'worker')->get();

        return view('pages.tasker.manage-assign-siswa.assign-siswa', compact('user', 'tesSiswa', 'tes', 'worker'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|array',
            'user_id.*' => 'required|exists:users,id',
            'tes_id' => 'required|exists:tes,id',
        ]);

        foreach ($request->user_id as $userId) {
            $exist = TesSiswa::where('user_id', $userId)
                ->where('tes_id', $request->tes_id)
                ->exists();
            if ($exist) {
                $userName = \App\Models\User::find($userId)?->name ?? 'Worker';
                return redirect()->back()->with('error', "Siswa {$userName} sudah diassign.");
            }
        }

        foreach ($request->user_id as $userId) {
            TesSiswa::create([
                'user_id' => $userId,
                'tes_id' => $request->tes_id,
            ]);
        }

        return redirect()->back()->with('success', 'Siswa berhasil ditambahkan');
    }

    public function delete($id)
    {
        $siswa = TesSiswa::find($id);
        $siswa->delete();

        return redirect()->back()->with('success', 'Siswa berhasil dihapus di task ini');
    }
}
