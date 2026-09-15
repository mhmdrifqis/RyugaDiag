<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gejala;
use Illuminate\Http\Request;

class GejalaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $gejalas = Gejala::when($search, function ($query) use ($search) {
                return $query->where('kode_gejala', 'like', "%{$search}%")
                             ->orWhere('nama_gejala', 'like', "%{$search}%");
            })
            ->orderBy('kode_gejala')
            ->paginate(10);
            
        return view('admin.gejala.index', compact('gejalas', 'search'));
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
            \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\GejalaImport, $request->file('file'));
            return back()->with('success', 'Data Gejala berhasil diimport dari Excel.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengimport data: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('admin.gejala.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_gejala' => 'required|string|max:10|unique:gejalas,kode_gejala',
            'nama_gejala' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
        ]);

        Gejala::create($validated);

        return redirect()->route('admin.gejala.index')->with('success', 'Data gejala berhasil ditambahkan.');
    }

    public function edit(Gejala $gejala)
    {
        return view('admin.gejala.edit', compact('gejala'));
    }

    public function update(Request $request, Gejala $gejala)
    {
        $validated = $request->validate([
            'kode_gejala' => 'required|string|max:10|unique:gejalas,kode_gejala,' . $gejala->id,
            'nama_gejala' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
        ]);

        $gejala->update($validated);

        return redirect()->route('admin.gejala.index')->with('success', 'Data gejala berhasil diperbarui.');
    }

    public function destroy(Gejala $gejala)
    {
        if ($gejala->rules()->exists()) {
            return back()->with('error', 'Gejala tidak bisa dihapus karena sedang digunakan dalam Basis Pengetahuan.');
        }

        $gejala->delete();

        return redirect()->route('admin.gejala.index')->with('success', 'Data gejala berhasil dihapus.');
    }
}
