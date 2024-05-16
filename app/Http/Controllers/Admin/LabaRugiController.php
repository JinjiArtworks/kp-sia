<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CoaExport;
use App\Http\Controllers\Controller;
use App\Models\Coa;
use App\Models\TipeCoa;
use Illuminate\Http\Request;
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

    public function index()
    {
        $coa = Coa::all();
        $tipe_coa = TipeCoa::all();
        return view('admin.labarugi', compact('coa', 'tipe_coa'));
    }
    public function store(Request $request)
    {
        Coa::create([
            'nama_akun' => $request->nama_akun,
            'saldo' => $request->saldo_coa,
            'tipe_coa_id' => $request->tipe_coa,
        ]);
        return redirect('/data-coa')->with('success', 'coa berhasil ditambahkan');;
    }
    public function edit($id)
    {
        $coa = Coa::find($id);
        return view('staff.coa.edit', compact('coa'));
    }
    public function update(Request $request)
    {
        $coa = Coa::find($request->id);
        Coa::where('id', $request->id)
            ->update(
                [
                    'nama_akun' => $request->nama_akun,
                    'saldo' => $request->saldo_coa,
                    'tipe_coa_id' => $request->tipe_coa ? $request->tipe_coa : $coa->tipe_coa_id,
                ]
            );
        return redirect('/data-coa')->with('success', 'coa berhasil diubah');
    }
    public function destroy($id)
    {
        Coa::where('id', $id)->delete();
        return redirect()->back();
    }
    public function exportExcel()
    {
        try {
            return Excel::download(new CoaExport, 'coa.xlsx');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to export users: ' . $e->getMessage());
        }
    }
    public function exportPDF()
    {
        $coa = Coa::all();
        $html = view('pdf.coa', compact('coa'))->render(); // render html pdf page, not the main blade pages!

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);

        return $mpdf->Output('coa.pdf', 'D');
    }
}
