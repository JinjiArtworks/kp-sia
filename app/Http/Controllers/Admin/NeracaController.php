<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BukuBesarExport;
use App\Exports\CashFlowExport;
use App\Exports\CoaExport;
use App\Exports\NeracaExport;
use App\Http\Controllers\Controller;
use App\Models\BukuBesar;
use App\Models\CashFlow;
use App\Models\Coa;
use App\Models\TipeCoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Mpdf\Mpdf;

class NeracaController extends Controller
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
            ->where('c.tipe_coa_id', 1)
            ->orWhere('c.tipe_coa_id', 3)
            ->when(
                $request->start_date !=  null,
                function ($q) use ($request) {
                    return $q->whereBetween('cf.date', [$request->start_date, $request->end_date]);
                }
            )
            // ->where('b.coa_id', ) menampilkan kode coa utk pendapatan dan biaya saja
            ->get();
        return view('admin.neraca', compact('cashflow', 'start_date', 'end_date'));
    }
    public function exportExcel()
    {
        try {
            return Excel::download(new NeracaExport, 'neraca.xlsx');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to export users: ' . $e->getMessage());
        }
    }
    public function exportPDF()
    {
        $cashflow = DB::table('cashflow as cf')
            ->select(
                'cf.name',
                'cf.saldo',
                'cf.date',
                'c.nama_akun',
                'c.id',
            )
            ->join('coa as c', 'c.id', 'cf.coa_id')
            ->where('c.tipe_coa_id', 1)
            ->orWhere('c.tipe_coa_id', 3)
            ->get();
        $html = view('pdf.neraca', compact('cashflow'))->render(); // render html pdf page, not the main blade pages!

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);

        return $mpdf->Output('neraca.pdf', 'D');
    }
}
