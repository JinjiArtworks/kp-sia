<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BukuBesarExport;
use App\Exports\CashFlowExport;
use App\Exports\CoaExport;
use App\Exports\NeracaExport;
use App\Exports\NeracaViewExport;
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
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        // $totalAktiva =
        //     DB::table('cashflow as cf')
        //     ->select(
        //         DB::raw('SUM(cf.saldo) as total_aktiva')
        //     )
        //     ->join('coa as c', 'c.id', '=', 'cf.coa_id')
        //     ->where('c.tipe_coa_id', 1)
        //     ->whereIn('cf.id', function ($query) {
        //         // where cf.id ada di tb cash flow
        //         // Mengelompokkan data terakhir dari masing-masing coa_id berdasarkan id cashflow.
        //         $query->select(DB::raw('MAX(id)'))
        //             // Max(id), is to get the latest entry from tb cashflow and grouped by the coa_id
        //             ->from('cashflow')
        //             ->groupBy('coa_id');
        //     })
        //     ->first();
        // dd($totalAktiva);
        $cashflow = DB::table('cashflow as cf')
            ->select(
                'cf.name',
                'cf.saldo',
                'cf.date',
                'c.nama_akun',
                'tc.name as coa_name',
                'c.id',
                'cf.coa_id',
                // DB::raw('(SELECT SUM(cf.saldo) FROM cashflow cf WHERE cf.coa_id = 14) as total_saldo')
            )
            ->join('coa as c', 'c.id', '=', 'cf.coa_id')
            ->join('tipe_coa as tc', 'tc.id', '=', 'c.tipe_coa_id')
            ->whereIn('cf.id', function ($query) {
                // where cf.id ada di tb cash flow
                // Mengelompokkan data terakhir dari masing-masing coa_id berdasarkan id cashflow.
                $query->select(DB::raw('MAX(id)'))
                    // Max(id), is to get the latest entry from tb cashflow and grouped by the coa_id
                    ->from('cashflow')
                    ->groupBy('coa_id');
            })
            ->whereIn('c.tipe_coa_id', [1, 2, 3, 4])
            ->when(
                $request->start_date !=  null,
                function ($q) use ($request) {
                    return $q->whereBetween('cf.date', [$request->start_date, $request->end_date]);
                }
            )
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
                'tc.name as coa_name',
                'c.nama_akun',
                'c.id',
            )
            ->join('coa as c', 'c.id', 'cf.coa_id')
            ->join('tipe_coa as tc', 'tc.id', 'c.tipe_coa_id')
            ->where('c.tipe_coa_id', 1)
            ->orWhere('c.tipe_coa_id', 3)
            ->get();
        $html = view('pdf.neraca', compact('cashflow'))->render(); // render html pdf page, not the main blade pages!

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);

        return $mpdf->Output('neraca.pdf', 'D');
    }
}
