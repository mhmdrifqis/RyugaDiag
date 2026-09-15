<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use App\Models\Diagnosa;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $diagnosas = Diagnosa::with('kerusakan')
            ->where('user_id', auth()->id())
            ->orderBy('tanggal_diagnosa', 'desc')
            ->paginate(10);
            
        return view('teknisi.riwayat.index', compact('diagnosas'));
    }

    public function show($id)
    {
        $diagnosa = Diagnosa::with(['kerusakan', 'detailDiagnosas.gejala'])->findOrFail($id);

        if ($diagnosa->user_id !== auth()->id()) {
            abort(403, 'Anda tidak berhak melihat hasil diagnosa ini.');
        }

        return view('teknisi.diagnosa.hasil', compact('diagnosa'));
    }
}
