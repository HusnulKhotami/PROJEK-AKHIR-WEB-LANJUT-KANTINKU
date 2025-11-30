<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransaksiExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Transaksi::select('id', 'jumlah', 'created_at')->get();
        // bisa kamu sesuaikan kolomnya
    }

    public function headings(): array
    {
        return [
            'ID',
            'Jumlah',
            'Tanggal',
        ];
    }
}