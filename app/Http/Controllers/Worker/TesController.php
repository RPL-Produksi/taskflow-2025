<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\HasilTes;
use App\Models\JawabanSiswa;
use App\Models\Soal;
use App\Models\Tes;
use App\Models\TesSiswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $tes = TesSiswa::where('user_id', $user->id)
        ->with(['tes', 'user'])
        ->with(['tes.hasilTes' => function ($q) use ($user) {
            $q->where('user_id', $user->id);
        }])
        ->get();
    

        return view('pages.worker.tes.tes', compact('user', 'tes'));
    }

    public function start(Tes $tes)
    {
        $user = Auth::user();
        $soals = $tes->soals()->with('pilihan')->get();
        $tesSiswa = TesSiswa::where('tes_id', $tes->id)->where('user_id', auth()->id())->first();

        if (!$tesSiswa) {
            abort(403, 'Tes tidak tersedia.');
        }

        if ($tesSiswa->status === 'sudah_mengerjakan') {
            return redirect()->route('tes')->with('error', 'Kamu sudah mengerjakan tes ini.');
        }

        if (Carbon::now()->gt(Carbon::parse($tes->deadline))) {
            return redirect()->route('tes')->with('error', 'Deadline tes sudah lewat.');
        }
        return view('pages.worker.tes.start-tes', compact('tes', 'soals', 'user'));
    }

    public function submit(Request $request, Tes $tes)
    {
        $request->validate([
            'jawaban' => 'required|array',
        ]);

        $benar = 0;
        foreach ($request->jawaban as $soalId => $jawaban) {
            $soal = Soal::find($soalId);

            JawabanSiswa::create([
                'user_id' => auth()->id(),
                'soal_id' => $soalId,
                'jawaban' => $jawaban,
            ]);

            if ($soal->jawaban_benar === $jawaban) {
                $benar++;
            }
        }

        $nilai = ($benar / count($request->jawaban)) * 100;

        HasilTes::create([
            'user_id' => auth()->id(),
            'tes_id' => $tes->id,
            'nilai' => $nilai
        ]);

        // Update status di tabel tes_siswas
        $tesSiswa = TesSiswa::where('tes_id', $tes->id)
            ->where('user_id', auth()->id())
            ->first();
        if ($tesSiswa) {
            $tesSiswa->update(['status' => 'sudah_mengerjakan']);
        }

        return redirect()->route('tes')->with('success', 'Tes selesai! Nilai kamu: ' . $nilai);
    }


    public function saveJawaban(Request $request)
    {
        $request->validate([
            'soal_id' => 'required|exists:soals,id',
            'jawaban' => 'required|in:A,B,C,D',
        ]);

        // Mendapatkan user yang sedang login
        $userId = auth()->id();

        // Simpan jawaban ke database
        JawabanSiswa::updateOrCreate(
            ['user_id' => $userId, 'soal_id' => $request->soal_id],
            ['jawaban' => $request->jawaban]
        );

        return response()->json(['success' => true]);
    }

}
