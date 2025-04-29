<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\Tes;
use App\Models\TesSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $tes = TesSiswa::where('user_id', $user->id)->with('tes')->with('user')->get();

        return view('pages.worker.tes.tes', compact('user', 'tes'));
    }

    public function start(Tes $tes)
    {
        $user = Auth::user();
        $soals = $tes->soals()->with('pilihan')->get();
        return view('pages.worker.tes.start-tes', compact('tes', 'soals', 'user'));
    }
}
