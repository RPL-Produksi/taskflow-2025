<?php

namespace App\Http\Controllers\Tasker;

use App\Exports\NilaiExport;
use App\Http\Controllers\Controller;
use App\Models\HasilTes;
use App\Models\Task;
use App\Models\Tes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ManageTesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $tes = Tes::where('user_id', $user->id)->get();

        return view('pages.tasker.manage-tes.manage-tes', compact('user', 'tes'));
    }

    public function add()
    {
        $user = Auth::user();
        return view('pages.tasker.manage-tes.add-tes', compact('user'));
    }

    public function edit($id)
    {
        $user = Auth::user();
        $tes = Tes::find($id);

        return view('pages.tasker.manage-tes.edit-tes', compact('user', 'tes'));
    }

    public function nilai(Tes $tes)
    {
        $user = Auth::user();
        $nilai = HasilTes::where('tes_id', $tes->id)->with('user')->get();

        return view('pages.tasker.manage-tes.nilai', compact('tes', 'user', 'nilai'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'nullable',
            'description' => 'nullable',
            'deadline' => 'nullable',
        ]);

        $user = Auth::user();

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('image', 'public');
        }

        Tes::create([
            'title' => $request->title,
            'image' => $path,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'user_id' => $user->id,
        ]);

        return redirect()->route('manage.tes')->with('success', 'Tes berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required',
            'image' => 'nullable',
            'description' => 'nullable',
            'deadline' => 'nullable',
        ]);

        $tes = Tes::find($id);

        if ($request->hasFile('image')) {
            $data['image'] = $path = $request->file('image')->store('image', 'public');
        } else {
            unset($data['image']);
        }

        $tes->update($data);

        return redirect()->route('manage.tes')->with('success', 'Tes berhasil diedit');
    }

    public function delete($id)
    {
        $tes = Tes::find($id);
        $tes->delete();

        return redirect()->back()->with('success', 'Tes berhasil dihapus');
    }

    public function export(Request $request)
    {
        $tes = Tes::findOrFail($request->tes_id);
        $filename = 'Nilai_' . str_replace(' ', '_', $tes->title) . '.xlsx';

        return Excel::download(new NilaiExport($tes->id, $tes->title), $filename);
    }

}
