<?php

namespace App\Exports;

use App\Models\TteRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TteExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = TteRequest::query();

        // Search
        if ($this->request->search) {
            $search = $this->request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                    ->orWhere('nip', 'like', '%' . $search . '%')
                    ->orWhere('opd', 'like', '%' . $search . '%')
                    ->orWhere('no_hp', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%');
            });
        }

        // Filter Jenis Permohonan / Layanan
        if ($this->request->jenis_permohonan) {
            $query->where('jenis_permohonan', $this->request->jenis_permohonan);
        }

        // Filter Bulan
        if ($this->request->bulan) {
            $query->whereMonth('created_at', $this->request->bulan);
        }

        // Filter Tahun
        if ($this->request->tahun) {
            $query->whereYear('created_at', $this->request->tahun);
        }

        return $query->latest()->get([
            'id',
            'nama_lengkap',
            'nip',
            'opd',
            'no_hp',
            'jenis_permohonan',
            'created_at'
        ]);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Lengkap',
            'NIP',
            'OPD',
            'No HP',
            'Jenis Permohonan',
            'Tanggal'
        ];
    }
}
