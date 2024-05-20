<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CoaExport;
use App\Exports\LabaRugiExport;
use App\Http\Controllers\Controller;
use App\Models\BukuBesar;
use App\Models\Coa;
use App\Models\LabaRugi;
use App\Models\TipeCoa;
use App\Models\TipePendapatan;
use App\Models\TipePengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Mpdf\Mpdf;

class LabaRugiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // dd($request->all());
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $cashflow = DB::table('cashflow as cf')
            ->select(
                'cf.name',
                'cf.saldo',
                'cf.date',
                'c.nama_akun',
                'c.id',
            )
            ->join('coa as c', 'c.id', 'cf.coa_id')
            // ->where('c.tipe_coa_id', 5)
            ->when(
                $request->start_date !=  null,
                function ($q) use ($request) {
                    return $q->whereBetween('cf.date', [$request->start_date, $request->end_date]);
                }
            )
            // ->where('b.coa_id', ) menampilkan kode coa utk pendapatan dan biaya saja
            ->get();
        return view('admin.labarugi', compact('cashflow', 'start_date', 'end_date'));
    }
    public function exportExcel()
    {
        try {
            return Excel::download(new LabaRugiExport, 'labarugi.xlsx');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to export users: ' . $e->getMessage());
        }
    }
    public function exportPDF()
    {
        $cashflow = DB::table('cashflow as cf')
            ->select(
                'c.nama_akun',
                'cf.name',
                'cf.date',
                'cf.saldo',
            )
            ->join('coa as c', 'c.id', 'cf.coa_id')
            // ->where('c.tipe_coa_id', 5)
            ->get();
        $html = view('pdf.labarugi', compact('cashflow'))->render(); // render html pdf page, not the main blade pages!

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);

        return $mpdf->Output('labarugi.pdf', 'D');
    }
}
