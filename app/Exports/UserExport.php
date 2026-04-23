<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return User::select(
            'name',
            'phone',
            'total_messages',
            'first_chat_at',
            'created_at'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Nomor WA',
            'Total Pesan',
            'Pertama Chat',
            'Tanggal Dibuat'
        ];
    }
}
