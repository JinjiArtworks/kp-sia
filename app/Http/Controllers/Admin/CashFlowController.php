<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CashFlowExport;
use App\Exports\CoaExport;
use App\Http\Controllers\Controller;
use App\Models\BukuBesar;
use App\Models\CashFlow;
use App\Models\Coa;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Mpdf\Mpdf;

class CashFlowController extends Controller
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

    // public function index()
    // {
    //     $cashflow = CashFlow::all();
    //     $coa = Coa::all();
    //     return view('admin.cashflow', compact('cashflow', 'coa'));
    // }
    public function index(Request $request)
    {
        // dd($request->all());
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $cashflow = DB::table('cashflow as cf')
            ->select(
                'cf.*',
                'c.no_reff',
                'c.nama_akun',
                'u.name as username',
            )
            ->join('coa as c', 'c.id', 'cf.coa_id')
            ->join('users as u', 'u.id', 'cf.user_id')
            ->when(
                $request->start_date !=  null,
                function ($q) use ($request) {
                    return $q->whereBetween('cf.date', [$request->start_date, $request->end_date]);
                }
            )
            ->get();
        $coa = Coa::all();
        return view('admin.cashflow', compact('cashflow', 'coa', 'start_date', 'end_date'));
    }
    public function store(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required',
        //     'debet' => 'required',
        //     'credit' => 'required',
        //     'date' => 'required',
        //     'coa_id' => 'required',
        // ]);
        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 422);
        // }
        $user = Auth::user()->id;
        $cashflow = CashFlow::whereCoaId($request->coa_id)->orderBy('created_at', 'desc')->first();
        $newCashflow = CashFlow::create([
            'name' => $request->name,
            'debet' => $request->debet ? $request->debet : 0,
            'credit' => $request->credit ? $request->credit : 0,
            'saldo' => $request->credit ? abs($cashflow->saldo - $request->credit) : abs($cashflow->saldo + $request->debet),
            'remarks' => $request->remarks,
            'date' => $request->date,
            'coa_id' => $request->coa_id,
            'user_id' => $user,
        ]);
        BukuBesar::create([
            'cashflow_id' => $newCashflow->id,
            'coa_id' => $request->coa_id ? $request->coa_id : $cashflow->coa_id,
            'debet' => $request->debet ? $request->debet : 0,
            'credit' => $request->credit ? $request->credit : 0,
        ]);
        return redirect('/data-cashflow')->with('success', 'coa berhasil ditambahkan');
    }
    public function edit($id)
    {
        $coa = Coa::find($id);
        return view('staff.coa.edit', compact('coa'));
    }
    public function update(Request $request)
    {
        $user = Auth::user()->id;
        CashFlow::where('id', $request->id)->delete();

        $cashflow = CashFlow::whereCoaId($request->coa_id)->orderBy('created_at', 'desc')->first();
        $newCashflow = CashFlow::create([
            'name' => $request->name,
            'debet' => $request->debet ? $request->debet : 0,
            'credit' => $request->credit ? $request->credit : 0,
            'saldo' => $request->credit ? $cashflow->saldo - $request->credit : $cashflow->saldo + $request->debet,
            'remarks' => $request->remarks,
            'date' => $request->date,
            'coa_id' => $request->coa_id,
            'user_id' => $user,
        ]);
        BukuBesar::create([
            'cashflow_id' => $newCashflow->id,
            'coa_id' => $request->coa_id ? $request->coa_id : $cashflow->coa_id,
            'debet' => $request->debet ? $request->debet : 0,
            'credit' => $request->credit ? $request->credit : 0,
        ]);
        return redirect('/data-cashflow')->with('success', 'coa berhasil diubah');
    }
    public function destroy($id)
    {
        CashFlow::where('id', $id)->delete();
        return redirect()->back();
    }
    public function exportExcel()
    {
        try {
            return Excel::download(new CashFlowExport, 'cashflow.xlsx');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to export users: ' . $e->getMessage());
        }
    }
    public function exportPDF()
    {
        $cashflow = DB::table('cashflow as cf')
            ->select(
                'cf.*',
                'c.no_reff',
                'c.nama_akun',
                'u.name as username',
            )
            ->join('coa as c', 'c.id', 'cf.coa_id')
            ->join('users as u', 'u.id', 'cf.user_id')
            ->get();
        $html = view('pdf.cashflow', compact('cashflow'))->render(); // render html pdf page, not the main blade pages!

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);

        return $mpdf->Output('cashflow.pdf', 'D');
    }
}
