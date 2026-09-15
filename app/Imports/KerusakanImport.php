<?php

namespace App\Imports;

use App\Models\Kerusakan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KerusakanImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['kode_kerusakan']) || empty(trim($row['kode_kerusakan']))) {
            return null;
        }

        return Kerusakan::updateOrCreate(
            ['kode_kerusakan' => trim($row['kode_kerusakan'])],
            [
                'nama_kerusakan' => trim($row['nama_kerusakan'] ?? ''),
                'deskripsi' => isset($row['deskripsi']) ? trim($row['deskripsi']) : null,
                'solusi' => trim($row['solusi'] ?? ''),
            ]
        );
    }
}
