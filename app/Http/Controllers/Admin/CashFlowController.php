<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CashFlowExport;
use App\Exports\CoaExport;
use App\Http\Controllers\Controller;
use App\Models\CashFlow;
use App\Models\Coa;
use App\Models\TipeCoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function index()
    {
        $cashflow = CashFlow::all();
        $coa = Coa::all();
        return view('admin.cashflow', compact('cashflow', 'coa'));
    }
    public function store(Request $request)
    {
        $user = Auth::user()->id;
        CashFlow::create([
            'name' => $request->name,
            'credit' => $request->credit,
            'debet' => $request->debet,
            'saldo' => $request->saldo,
            'remarks' => $request->remarks,
            'date' => $request->date,
            'coa_id' => $request->coa_id,
            'created_by' => $user,
        ]);
        return redirect('/data-cashflow')->with('success', 'coa berhasil ditambahkan');;
    }
    public function edit($id)
    {
        $coa = Coa::find($id);
        return view('staff.coa.edit', compact('coa'));
    }
    public function update(Request $request)
    {
        $user = Auth::user()->id;
        $cashflow = CashFlow::find($request->id);
        CashFlow::where('id', $request->id)
            ->update(
                [
                    'name' => $request->name,
                    'credit' => $request->credit,
                    'debet' => $request->debet,
                    'saldo' => $request->saldo,
                    'remarks' => $request->remarks,
                    'date' => $request->date,
                    'coa_id' => $request->coa_id ? $request->coa_id : $cashflow->coa_id,
                    'created_by' => $user,
                ]
            );
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
        $cashflow = CashFlow::all();
        $html = view('pdf.cashflow', compact('cashflow'))->render(); // render html pdf page, not the main blade pages!

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);

        return $mpdf->Output('cashflow.pdf', 'D');
    }
}
