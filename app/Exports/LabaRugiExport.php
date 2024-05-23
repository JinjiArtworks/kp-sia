<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class LabaRugiExport implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents
{
    /**
     * Collection of CoA data.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return DB::table('cashflow as cf')
            ->select(
                'c.nama_akun',
                // 'cf.name',
                'tc.name as coa_name',
                'cf.saldo',
            )
            ->join('coa as c', 'c.id', '=', 'cf.coa_id')
            ->join('tipe_coa as tc', 'tc.id', '=', 'c.tipe_coa_id')
            ->whereIn('c.tipe_coa_id', [5, 6])
            ->whereIn('cf.id', function ($query) {
                // where cf.id ada di tb cash flow
                // Mengelompokkan data terakhir dari masing-masing coa_id berdasarkan id cashflow.
                $query->select(DB::raw('MAX(id)'))
                    // Max(id), is to get the latest entry from tb cashflow and grouped by the coa_id
                    ->from('cashflow')
                    ->groupBy('coa_id');
            })
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
            'Tipe Coa',
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
                $event->sheet->setCellValue('A1', 'Laba Rugi');
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
                $event->sheet->getStyle('A2:D2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                ]);
                $event->sheet->getStyle('A12:A14')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                ]);
                $setPendapatan = DB::table('cashflow as cf')
                    ->select(
                        DB::raw('SUM(cf.saldo) as total_pendapatan')
                    )
                    ->join('coa as c', 'c.id', '=', 'cf.coa_id')
                    ->where('c.tipe_coa_id', 5)
                    ->whereIn('cf.id', function ($query) {
                        $query->select(DB::raw('MAX(id)'))
                            ->from('cashflow')
                            ->groupBy('coa_id');
                    })
                    ->first();

                // SET AKTIVA
                $setBeban = DB::table('cashflow as cf')
                    ->select(
                        DB::raw('SUM(cf.saldo) as total_beban')
                    )
                    ->join('coa as c', 'c.id', '=', 'cf.coa_id')
                    ->where('c.tipe_coa_id', 6)
                    ->whereIn('cf.id', function ($query) {
                        $query->select(DB::raw('MAX(id)'))
                            ->from('cashflow')
                            ->groupBy('coa_id');
                    })
                    ->first();
                $event->sheet->setCellValue('A12', 'Total Pendapatan');
                $event->sheet->setCellValue('C12', $setPendapatan->total_pendapatan);
                $event->sheet->setCellValue('A13', 'Total Beban');
                $event->sheet->setCellValue('C13', $setBeban->total_beban);
                $event->sheet->setCellValue('A14', 'Laba / Rugi');
                $event->sheet->setCellValue('C14', $setPendapatan->total_pendapatan - $setBeban->total_beban);
            },
        ];
    }
}
