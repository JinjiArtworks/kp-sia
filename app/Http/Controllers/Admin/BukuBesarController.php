<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BukuBesarExport;
use App\Exports\CashFlowExport;
use App\Exports\CoaExport;
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

class BukuBesarController extends Controller
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
                'cf.debet',
                'cf.credit',
                'cf.saldo',
                'cf.date',
                'cf.remarks',
                'c.no_reff',
                'c.nama_akun',
            )
            ->join('coa as c', 'c.id', 'cf.coa_id')
            ->when(
                $request->start_date !=  null,
                function ($q) use ($request) {
                    return $q->whereBetween('cf.date', [$request->start_date, $request->end_date]);
                }
            )
            ->get();
        return view('admin.bukubesar', compact('cashflow', 'start_date', 'end_date'));
    }
    public function exportExcel()
    {
        try {
            return Excel::download(new BukuBesarExport, 'bukubesar.xlsx');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to export users: ' . $e->getMessage());
        }
    }
    public function exportPDF()
    {
        $bukubesar = DB::table('buku_besar as b')
            ->select(
                'b.debet',
                'b.credit',
                'c.no_reff',
                'c.nama_akun',
                'c.saldo',
                'cf.date',
                'cf.remarks',
            )
            ->join('coa as c', 'c.id', 'b.coa_id')
            ->leftJoin('cashflow as cf', 'cf.coa_id', 'c.id')
            ->get();
        $html = view('pdf.bukubesar', compact('bukubesar'))->render(); // render html pdf page, not the main blade pages!

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);

        return $mpdf->Output('bukubesar.pdf', 'D');
    }
}
