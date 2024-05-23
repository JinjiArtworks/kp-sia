<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class NeracaExport implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents
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
            ->whereIn('c.tipe_coa_id', [1, 2, 3, 4])
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
            // 'Keterangan Akun',
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
                $event->sheet->setCellValue('A1', 'Laporan Neraca');
                // Applying bold style to the header
                $event->sheet->getStyle('A1:A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                    ],
                ]);
                // Applying bold style to the first row of actual data
                $event->sheet->getStyle('A2:E2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                ]);
                $event->sheet->getStyle('A18:A30')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                ]);
                $setAset = DB::table('cashflow as cf')
                    ->select(
                        DB::raw('SUM(cf.saldo) as total_aset')
                    )
                    ->join('coa as c', 'c.id', '=', 'cf.coa_id')
                    ->where('c.tipe_coa_id', 1)
                    ->whereIn('cf.id', function ($query) {
                        $query->select(DB::raw('MAX(id)'))
                            ->from('cashflow')
                            ->groupBy('coa_id');
                    })
                    ->first();

                // SET AKTIVA
                $setAkumulasi = DB::table('cashflow as cf')
                    ->select(
                        DB::raw('SUM(cf.saldo) as total_akumulasi')
                    )
                    ->join('coa as c', 'c.id', '=', 'cf.coa_id')
                    ->where('c.tipe_coa_id', 2)
                    ->whereIn('cf.id', function ($query) {
                        $query->select(DB::raw('MAX(id)'))
                            ->from('cashflow')
                            ->groupBy('coa_id');
                    })
                    ->first();
                $event->sheet->setCellValue('A18', 'Total Aset');
                $event->sheet->setCellValue('C18', $setAset->total_aset);
                $event->sheet->setCellValue('A19', 'Total Akumulasi');
                $event->sheet->setCellValue('C19', $setAkumulasi->total_akumulasi);
                $event->sheet->setCellValue('A20', 'Total Aktiva');
                $event->sheet->setCellValue('C20', $setAset->total_aset - $setAkumulasi->total_akumulasi);
                // END SET AKTIVA


                // SET PASIVA
                $setKewajiban = DB::table('cashflow as cf')
                    ->select(
                        DB::raw('SUM(cf.saldo) as total_kewajiban')
                    )
                    ->join('coa as c', 'c.id', '=', 'cf.coa_id')
                    ->where('c.tipe_coa_id', 3)
                    ->whereIn('cf.id', function ($query) {
                        $query->select(DB::raw('MAX(id)'))
                            ->from('cashflow')
                            ->groupBy('coa_id');
                    })
                    ->first();
                $setEkuitas = DB::table('cashflow as cf')
                    ->select(
                        DB::raw('SUM(cf.saldo) as total_ekuitas')
                    )
                    ->join('coa as c', 'c.id', '=', 'cf.coa_id')
                    ->where('c.tipe_coa_id', 4)
                    ->whereIn('cf.id', function ($query) {
                        $query->select(DB::raw('MAX(id)'))
                            ->from('cashflow')
                            ->groupBy('coa_id');
                    })
                    ->first();

                $event->sheet->setCellValue('A22', 'Total Kewajiban');
                $event->sheet->setCellValue('C22', $setKewajiban->total_kewajiban);
                $event->sheet->setCellValue('A23', 'Total Ekuitas');
                $event->sheet->setCellValue('C23', $setEkuitas->total_ekuitas);
                $event->sheet->setCellValue('A24', 'Total Pasiva');
                $event->sheet->setCellValue('C24', $setKewajiban->total_kewajiban + $setEkuitas->total_ekuitas);

                // End SET PASIVA
            },
        ];
    }
}
