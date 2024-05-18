<?php

namespace App\Exports;

use App\Models\Coa;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class BukuBesarExport implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents
{
    /**
     * Collection of CoA data.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return DB::table('buku_besar as b')
            ->select(
                'c.nama_akun',
                'c.no_reff',
                'b.debet',
                'b.kredit',
                'cf.date',
                'cf.remarks',
                'c.saldo',
            )
            ->join('coa as c', 'c.id', 'b.coa_id')
            ->leftJoin('cashflow as cf', 'cf.coa_id', 'c.id')
            ->get();
    }

    /**
     * Specify the headings for the columns.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Nama Akun',
            'Nomor Akun',
            'Debet',
            'Kredit',
            'Tanggal',
            'Catatan',
            'Saldo',
        ];
    }

    /**
     * Define the starting cell for the export.
     *
     * @return string
     */
    public function startCell(): string
    {
        return 'A2';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Adding a custom header
                $event->sheet->setCellValue('A1', 'BUKU BESAR');
                // Adding a custom footer
                // $event->sheet->setCellValue('A50', 'Custom Footer');
                // Applying bold style to the header
                $event->sheet->getStyle('A1:A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                    ],
                ]);

                // Applying bold style to the first row of actual data
                $event->sheet->getStyle('A2:C2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                ]);
            },
        ];
    }
}
