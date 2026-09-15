<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use App\Models\Diagnosa;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDiagnosa = Diagnosa::where('user_id', auth()->id())->count();
        $diagnosaSukses = Diagnosa::where('user_id', auth()->id())->whereNotNull('kerusakan_id')->count();
        $diagnosaGagal = Diagnosa::where('user_id', auth()->id())->whereNull('kerusakan_id')->count();
        
        $riwayatTerbaru = Diagnosa::with('kerusakan')
            ->where('user_id', auth()->id())
            ->orderBy('tanggal_diagnosa', 'desc')
            ->take(5)
            ->get();

        return view('teknisi.dashboard', compact(
            'totalDiagnosa', 'diagnosaSukses', 'diagnosaGagal', 'riwayatTerbaru'
        ));
    }
}
