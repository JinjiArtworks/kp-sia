<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class CoaExport implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents
{
    /**
     * Collection of CoA data.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return DB::table('coa as c')
        ->select('c.nama_akun','c.saldo','t.name as tipe_coa_name')
        ->join('tipe_coa as t', 't.id','c.tipe_coa_id')
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
            'Saldo',
            'Tipe Akun'
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

    /**
     * Register events for the export.
     *
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Adding a custom header
                $event->sheet->setCellValue('A1', 'Daftar COA');
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
