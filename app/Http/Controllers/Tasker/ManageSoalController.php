<?php

namespace App\Http\Controllers\Tasker;

use App\Http\Controllers\Controller;
use App\Models\Pilihan;
use App\Models\Soal;
use App\Models\Tes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageSoalController extends Controller
{
    public function index(Tes $tes)
    {
        $soal = Soal::where('tes_id', $tes->id)->get();
        $user = Auth::user();

        return view('pages.tasker.manage-soal.manage-soal', compact('user', 'soal', 'tes'));
    }

    public function add(Tes $tes)
    {
        $user = Auth::user();

        return view('pages.tasker.manage-soal.add', compact('user', 'tes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'tes_id' => 'required',
            'pilihan' => 'required|array',
            'jawaban_benar' => 'required|in:A,B,C,D',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('image', 'public');
        }

        $soal = Soal::create([
            'pertanyaan' => $request->pertanyaan,
            'tes_id' => $request->tes_id,
            'image' => $path,
            'jawaban_benar' => $request->jawaban_benar,
        ]);

        foreach ($request->pilihan as $opsi => $isi_pilihan) {
            Pilihan::create([
                'soal_id' => $soal->id,
                'opsi' => $opsi,
                'isi_pilihan' => $isi_pilihan,
            ]);
        }

        return redirect()->route('manage.tes')->with('success', 'Soal dan pilihan berhasil disimpan!');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:txt',
            'tes_id' => 'required',
        ]);

        $fileContent = file($request->file('file')->getRealPath(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        $soalData = [];
        $currentSoal = [];

        foreach ($fileContent as $line) {
            $line = trim($line);
            if (str_starts_with($line, 'Soal:')) {
                if (!empty($currentSoal)) {
                    $soalData[] = $currentSoal;
                    $currentSoal = [];
                }
                $currentSoal['pertanyaan'] = substr($line, 6);
            } elseif (preg_match('/^[A-D]\./', $line)) {
                $opsi = substr($line, 0, 1);
                $text = trim(substr($line, 2));
                $currentSoal['pilihan'][$opsi] = $text;
            } elseif (str_starts_with($line, 'Jawaban:')) {
                $currentSoal['jawaban_benar'] = trim(substr($line, 8));
            }
        }

        if (!empty($currentSoal)) {
            $soalData[] = $currentSoal;
        }

        foreach ($soalData as $data) {
            $soal = Soal::create([
                'tes_id' => $request->tes_id,
                'pertanyaan' => $data['pertanyaan'],
                'jawaban_benar' => $data['jawaban_benar'],
            ]);

            foreach ($data['pilihan'] as $opsi => $isi) {
                Pilihan::create([
                    'soal_id' => $soal->id,
                    'opsi' => $opsi,
                    'isi_pilihan' => $isi,
                ]);
            }
        }

        return back()->with('success', 'Soal berhasil diimpor dari file .txt!');
    }

    public function delete($id) {
        $soal = Soal::find($id);
        $soal->delete();

        return redirect()->back()->with('success', 'Soal ini berhasil di hapus');
    }
}
