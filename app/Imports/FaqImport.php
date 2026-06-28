<?php

namespace App\Imports;

use App\Models\Faq;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class FaqImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {

            // 1. Lewati baris pertama (Header Kolom: layanan_id, pertanyaan, jawaban)
            if ($index == 0) continue;

            // 2. Pengaman (Skip otomatis jika ada baris kosong di tengah-tengah Excel)
            if (empty($row[0]) || empty($row[1]) || empty($row[2])) {
                continue;
            }

            // 3. Masukkan ke database FAQ
            Faq::create([
                'layanan_id' => $row[0],
                'pertanyaan' => $row[1],
                'jawaban'    => $row[2],
            ]);
        }
    }
}
