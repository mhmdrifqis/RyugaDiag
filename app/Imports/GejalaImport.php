<?php

namespace App\Imports;

use App\Models\Gejala;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GejalaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['kode_gejala']) || empty(trim($row['kode_gejala']))) {
            return null;
        }

        return Gejala::updateOrCreate(
            ['kode_gejala' => trim($row['kode_gejala'])],
            [
                'nama_gejala' => trim($row['nama_gejala'] ?? ''),
                'deskripsi' => isset($row['deskripsi']) ? trim($row['deskripsi']) : null,
            ]
        );
    }
}
