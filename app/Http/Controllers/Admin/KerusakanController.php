<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kerusakan;
use Illuminate\Http\Request;

class KerusakanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $kerusakans = Kerusakan::when($search, function ($query) use ($search) {
                return $query->where('kode_kerusakan', 'like', "%{$search}%")
                             ->orWhere('nama_kerusakan', 'like', "%{$search}%");
            })
            ->orderBy('kode_kerusakan')
            ->paginate(10);
            
        return view('admin.kerusakan.index', compact('kerusakans', 'search'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls',
        ], [
            'file.required' => 'Silakan pilih file Excel/CSV terlebih dahulu.',
            'file.mimes' => 'Format file harus berupa .xlsx, .xls, atau .csv.'
        ]);

        try {
            \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\KerusakanImport, $request->file('file'));
            return back()->with('success', 'Data Kerusakan berhasil diimport dari Excel.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengimport data: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('admin.kerusakan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_kerusakan' => 'required|string|max:10|unique:kerusakans,kode_kerusakan',
            'nama_kerusakan' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'solusi' => 'nullable|string',
        ]);

        Kerusakan::create($validated);

        return redirect()->route('admin.kerusakan.index')->with('success', 'Data kerusakan berhasil ditambahkan.');
    }

    public function edit(Kerusakan $kerusakan)
    {
        return view('admin.kerusakan.edit', compact('kerusakan'));
    }

    public function update(Request $request, Kerusakan $kerusakan)
    {
        $validated = $request->validate([
            'kode_kerusakan' => 'required|string|max:10|unique:kerusakans,kode_kerusakan,' . $kerusakan->id,
            'nama_kerusakan' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'solusi' => 'nullable|string',
        ]);

        $kerusakan->update($validated);

        return redirect()->route('admin.kerusakan.index')->with('success', 'Data kerusakan berhasil diperbarui.');
    }

    public function destroy(Kerusakan $kerusakan)
    {
        if ($kerusakan->rules()->exists()) {
            return back()->with('error', 'Kerusakan tidak bisa dihapus karena sedang digunakan dalam Basis Pengetahuan.');
        }

        $kerusakan->delete();

        return redirect()->route('admin.kerusakan.index')->with('success', 'Data kerusakan berhasil dihapus.');
    }
}
