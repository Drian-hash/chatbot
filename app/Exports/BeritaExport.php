<?php

namespace App\Exports;

use App\Models\Berita;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BeritaExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Berita::query();

        if ($this->request->search) {
            $query->where('kode', 'like', '%'.$this->request->search.'%')
                  ->orWhere('isi_ringkas', 'like', '%'.$this->request->search.'%');
        }

        if ($this->request->bulan) {
            $query->whereMonth('tanggal_surat', $this->request->bulan);
        }

        if ($this->request->tahun) {
            $query->whereYear('tanggal_surat', $this->request->tahun);
        }

        return $query->get([
            'kode',
            'nomor_surat',
            'tujuan_surat',
            'tanggal_surat',
            'isi_ringkas',
            'keterangan'
        ]);
    }

    public function headings(): array
    {
        return [
            'Kode',
            'Nomor Surat',
            'Tujuan',
            'Tanggal',
            'Isi Ringkas',
            'Keterangan'
        ];
    }
}
