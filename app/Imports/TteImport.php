<?php

namespace App\Imports;

use App\Models\TteRequest;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class TteImport implements ToModel, WithStartRow
{
    /**
     * Mulai dari baris ke-2 (skip header Excel)
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * Mapping kolom Excel ke database
     */
    public function model(array $row)
    {
        return new TteRequest([
            'timestamp'        => now(),
            'nama_lengkap'     => $row[0] ?? null,
            'nip'              => $row[1] ?? null,
            'opd'              => $row[2] ?? null,
            'no_hp'            => $row[3] ?? null,
            'jenis_permohonan' => $row[4] ?? null,
        ]);
    }
}
