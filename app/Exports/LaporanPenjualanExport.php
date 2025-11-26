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

class LaporanPenjualanExport implements FromView, WithTitle, ShouldAutoSize, WithStyles
{
    protected $data;
    protected $title;

    public function __construct($data, $title = 'Laporan Penjualan')
    {
        $this->data = $data;
        $this->title = $title;
    }

    public function view(): View
    {
        return view('exports.laporan-penjualan', [
            'pesanan' => $this->data['pesanan'],
            'totalPesanan' => $this->data['totalPesanan'],
            'totalPendapatan' => $this->data['totalPendapatan'],
            'rataPendapatan' => $this->data['rataPendapatan'],
            'laporan_label' => $this->data['laporan_label'],
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        // Header style
        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '10B981'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Sub header (statistics)
        $sheet->getStyle('A3:H4')->applyFromArray([
            'font' => ['bold' => true, 'size' => 11],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
        ]);

        // Table header
        $sheet->getStyle('A6:H6')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '059669'],
            ],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'border' => [
                'allBorders' => ['borderStyle' => 'thin'],
            ],
        ]);

        // Data rows
        $lastRow = $sheet->getHighestRow();
        if ($lastRow > 6) {
            $sheet->getStyle('A7:H' . $lastRow)->applyFromArray([
                'border' => [
                    'allBorders' => ['borderStyle' => 'thin'],
                ],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
            ]);
        }

        // Currency format for price columns
        $sheet->getStyle('E7:E' . $lastRow)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('H7:H' . $lastRow)->getNumberFormat()->setFormatCode('#,##0');

        // Center alignment for number columns
        $sheet->getStyle('D7:D' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F7:F' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        return [];
    }

    public function title(): string
    {
        return 'Laporan Penjualan';
    }
}
