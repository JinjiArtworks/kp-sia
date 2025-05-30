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
                'tc.name as coa_name',
                'c.id'
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
            ->where('c.tipe_coa_id', 5)
            ->orWhere('c.tipe_coa_id', 6)
            ->when(
                $request->start_date !=  null,
                function ($q) use ($request) {
                    return $q->whereBetween('cf.date', [$request->start_date, $request->end_date]);
                }
            )
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
                'cf.name',
                'cf.saldo',
                'cf.date',
                'c.nama_akun',
                'tc.name as coa_name',
                'c.id'
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
            ->whereIn('c.tipe_coa_id', [5, 6])
            ->get();
        $html = view('pdf.labarugi', compact('cashflow'))->render(); // render html pdf page, not the main blade pages!

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);

        return $mpdf->Output('labarugi.pdf', 'D');
    }
}
