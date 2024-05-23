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
                'cf.name',
                'tc.name as coa_name',
                'c.no_reff',
                'c.nama_akun',
                'tc.name as coa_name',
            )
            ->join('coa as c', 'c.id', 'cf.coa_id')
            ->join('tipe_coa as tc', 'tc.id', 'c.tipe_coa_id')
            ->when(
                $request->start_date !=  null,
                function ($q) use ($request) {
                    return $q->whereBetween('cf.date', [$request->start_date, $request->end_date]);
                }
            )
            ->orderBy('cf.date','asc')
            ->get();
        $kas = CashFlow::whereCoaId(1)->get();
        $piutangUsaha = CashFlow::whereCoaId(2)->get();
        $sewaDimuka = CashFlow::whereCoaId(3)->get();
        $asuransiDimuka = CashFlow::whereCoaId(4)->get();
        $sediaanHabisPakai = CashFlow::whereCoaId(5)->get();
        $hutangUsaha = CashFlow::whereCoaId(6)->get();
        $hutangBankTop = CashFlow::whereCoaId(7)->get();
        $hutangBankMaju = CashFlow::whereCoaId(8)->get();
        $uangMukaMember = CashFlow::whereCoaId(9)->get();
        $modelHelena = CashFlow::whereCoaId(10)->get();
        $akDepresiasi = CashFlow::whereCoaId(11)->get();
        $hutangGaji = CashFlow::whereCoaId(12)->get();
        $prive = CashFlow::whereCoaId(13)->get();
        $pendapatanNonMember = CashFlow::whereCoaId(14)->get();
        $pendapatanMember = CashFlow::whereCoaId(15)->get();
        $biayaGaji = CashFlow::whereCoaId(16)->get();
        $biayaAsuransi = CashFlow::whereCoaId(17)->get();
        $biayaSewa = CashFlow::whereCoaId(18)->get();
        $biayaListrikEtc = CashFlow::whereCoaId(19)->get();
        $biayaLainLain = CashFlow::whereCoaId(20)->get();
        $biayaDepresiasiPeralatan = CashFlow::whereCoaId(21)->get();
        $peralatanSalon = CashFlow::whereCoaId(22)->get();
        return view('admin.bukubesar', compact(
            'cashflow',
            'kas',
            'piutangUsaha',
            'sewaDimuka',
            'asuransiDimuka',
            'sediaanHabisPakai',
            'hutangUsaha',
            'hutangBankTop',
            'hutangBankMaju',
            'uangMukaMember',
            'modelHelena',
            'akDepresiasi',
            'hutangGaji',
            'prive',
            'pendapatanNonMember',
            'pendapatanMember',
            'biayaGaji',
            'biayaAsuransi',
            'biayaSewa',
            'biayaListrikEtc',
            'biayaLainLain',
            'biayaDepresiasiPeralatan',
            'peralatanSalon',
            'start_date',
            'end_date'
        ));
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
        $cashflow = DB::table('cashflow as cf')
            ->select(
                'cf.debet',
                'cf.credit',
                'cf.saldo',
                'cf.date',
                'cf.name',
                'tc.name as coa_name',
                'c.no_reff',
                'c.nama_akun',
                'tc.name as coa_name',
            )
            ->join('coa as c', 'c.id', 'cf.coa_id')
            ->join('tipe_coa as tc', 'tc.id', 'c.tipe_coa_id')
            ->orderBy('cf.date','asc')
            ->get();
        $html = view('pdf.bukubesar', compact('cashflow'))->render(); // render html pdf page, not the main blade pages!

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);

        return $mpdf->Output('bukubesar.pdf', 'D');
    }
}
