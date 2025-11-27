<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class DetailPesananExport implements FromView, WithTitle, ShouldAutoSize, WithStyles
{
    protected $pesanan;

    public function __construct($pesanan)
    {
        $this->pesanan = $pesanan;
    }

    public function view(): View
    {
        return view('exports.detail-pesanan', [
            'pesanan' => $this->pesanan,
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        // Header info style
        $sheet->getStyle('A1:D2')->applyFromArray([
            'font' => ['bold' => true, 'size' => 12],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
        ]);

        // Items header
        $sheet->getStyle('A4:D4')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '10B981'],
            ],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'border' => [
                'allBorders' => ['borderStyle' => 'thin'],
            ],
        ]);

        // Data rows
        $lastRow = $sheet->getHighestRow();
        if ($lastRow > 4) {
            $sheet->getStyle('A5:D' . ($lastRow - 3))->applyFromArray([
                'border' => [
                    'allBorders' => ['borderStyle' => 'thin'],
                ],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
            ]);
        }

        // Summary rows (Subtotal, Tax, Total)
        if ($lastRow >= 3) {
            $sheet->getStyle('A' . ($lastRow - 2) . ':D' . $lastRow)->applyFromArray([
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => 'F0F0F0'],
                ],
                'border' => [
                    'allBorders' => ['borderStyle' => 'thin'],
                ],
            ]);
        }

        // Currency format
        $sheet->getStyle('C5:D' . $lastRow)->getNumberFormat()->setFormatCode('#,##0');

        return [];
    }

    public function title(): string
    {
        return 'Detail Pesanan #' . $this->pesanan->id;
    }
}
