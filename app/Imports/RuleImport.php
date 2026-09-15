<?php

namespace App\Imports;

use App\Models\Rule;
use App\Models\Kerusakan;
use App\Models\Gejala;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RuleImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['kode_kerusakan']) || empty(trim($row['kode_kerusakan'])) || !isset($row['kode_gejala']) || empty(trim($row['kode_gejala']))) {
            return null;
        }

        $kerusakan = Kerusakan::where('kode_kerusakan', trim($row['kode_kerusakan']))->first();

        if (!$kerusakan) {
            return null; // Lewati jika kerusakan tidak ditemukan
        }

        // Ambil array kode gejala yang dipisah koma (misal: G01, G02, G03)
        $kodeGejalas = array_map('trim', explode(',', $row['kode_gejala']));
        
        $gejalaIds = Gejala::whereIn('kode_gejala', $kodeGejalas)->pluck('id')->toArray();

        if (empty($gejalaIds)) {
            return null;
        }

        // Cari Rule yang sudah ada untuk kerusakan ini, atau buat baru
        $rule = Rule::firstOrCreate([
            'kerusakan_id' => $kerusakan->id,
        ]);

        // Karena satu Kerusakan hanya punya 1 Rule, kita sync gejala-gejalanya (menimpa yang lama)
        $rule->gejalas()->sync($gejalaIds);

        return $rule;
    }
}
