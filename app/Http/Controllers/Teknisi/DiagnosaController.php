<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use App\Models\Gejala;
use App\Models\Diagnosa;
use App\Services\ForwardChainingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiagnosaController extends Controller
{
    protected $fcService;

    public function __construct(ForwardChainingService $fcService)
    {
        $this->fcService = $fcService;
    }

    public function create()
    {
        $gejalas = Gejala::orderBy('kode_gejala')->get();
        return view('teknisi.diagnosa.create', compact('gejalas'));
    }

    public function proses(Request $request)
    {
        $request->validate([
            'gejala_ids' => 'required|array|min:1',
            'gejala_ids.*' => 'exists:gejalas,id',
        ], [
            'gejala_ids.required' => 'Anda harus memilih minimal satu gejala untuk melakukan diagnosa.'
        ]);

        $selectedGejalas = $request->gejala_ids;

        // Jalankan inferensi Forward Chaining
        $kerusakan = $this->fcService->diagnose($selectedGejalas);

        $diagnosa = null;

        DB::transaction(function () use ($selectedGejalas, $kerusakan, &$diagnosa) {
            // Simpan riwayat diagnosa
            $diagnosa = Diagnosa::create([
                'user_id' => auth()->id(),
                'kerusakan_id' => $kerusakan ? $kerusakan->id : null,
                'tanggal_diagnosa' => now(),
            ]);

            // Simpan detail gejala yang dipilih
            foreach ($selectedGejalas as $gejalaId) {
                $diagnosa->detailDiagnosas()->create([
                    'gejala_id' => $gejalaId
                ]);
            }
        });

        return redirect()->route('teknisi.diagnosa.hasil', $diagnosa->id)->with('success', 'Diagnosa berhasil dilakukan.');
    }

    public function hasil($id)
    {
        $diagnosa = Diagnosa::with(['kerusakan', 'detailDiagnosas.gejala'])->findOrFail($id);

        if (auth()->user()->role === 'teknisi' && $diagnosa->user_id !== auth()->id()) {
            abort(403, 'Anda tidak berhak melihat hasil diagnosa ini.');
        }

        return view('teknisi.diagnosa.hasil', compact('diagnosa'));
    }
}
