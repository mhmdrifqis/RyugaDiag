<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gejala;
use App\Models\Kerusakan;
use App\Models\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RuleController extends Controller
{
    public function index()
    {
        $rules = Rule::with(['kerusakan', 'gejalas'])->paginate(10);
        return view('admin.rule.index', compact('rules'));
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
            \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\RuleImport, $request->file('file'));
            return back()->with('success', 'Data Rule berhasil diimport dari Excel.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengimport data: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $kerusakans = Kerusakan::orderBy('kode_kerusakan')->get();
        $gejalas = Gejala::orderBy('kode_gejala')->get();
        return view('admin.rule.create', compact('kerusakans', 'gejalas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kerusakan_id' => 'required|exists:kerusakans,id',
            'gejala_ids' => 'required|array|min:1',
            'gejala_ids.*' => 'exists:gejalas,id',
        ]);

        // Check if rule for this kerusakan already exists to prevent duplicates (optional, based on logic)
        // If we want 1 Kerusakan to have multiple rules (OR logic), we skip this.
        // For simple Forward Chaining MVP, let's allow it, but we can also warn.
        
        DB::transaction(function () use ($request) {
            $rule = Rule::create([
                'kerusakan_id' => $request->kerusakan_id,
            ]);
            $rule->gejalas()->attach($request->gejala_ids);
        });

        return redirect()->route('admin.rule.index')->with('success', 'Basis Pengetahuan (Rule) berhasil ditambahkan.');
    }

    public function edit(Rule $rule)
    {
        $kerusakans = Kerusakan::orderBy('kode_kerusakan')->get();
        $gejalas = Gejala::orderBy('kode_gejala')->get();
        $selectedGejalas = $rule->gejalas->pluck('id')->toArray();
        
        return view('admin.rule.edit', compact('rule', 'kerusakans', 'gejalas', 'selectedGejalas'));
    }

    public function update(Request $request, Rule $rule)
    {
        $request->validate([
            'kerusakan_id' => 'required|exists:kerusakans,id',
            'gejala_ids' => 'required|array|min:1',
            'gejala_ids.*' => 'exists:gejalas,id',
        ]);

        DB::transaction(function () use ($request, $rule) {
            $rule->update([
                'kerusakan_id' => $request->kerusakan_id,
            ]);
            $rule->gejalas()->sync($request->gejala_ids);
        });

        return redirect()->route('admin.rule.index')->with('success', 'Basis Pengetahuan (Rule) berhasil diperbarui.');
    }

    public function destroy(Rule $rule)
    {
        $rule->delete(); // Cascades in DB or Eloquent handles it via sync if needed, but cascadeOnDelete is set.
        return redirect()->route('admin.rule.index')->with('success', 'Basis Pengetahuan (Rule) berhasil dihapus.');
    }
}
