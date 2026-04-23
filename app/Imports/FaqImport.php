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

            // skip header
            if ($index == 0) continue;

            Faq::create([
                'layanan_id' => $row[0],
                'pertanyaan' => $row[1],
                'jawaban' => $row[2],
            ]);
        }
    }
}
