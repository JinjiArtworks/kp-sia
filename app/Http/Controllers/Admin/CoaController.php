<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coa;
use App\Models\TipeCoa;
use Illuminate\Http\Request;

class CoaController extends Controller
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
        return view('admin.coa', compact('coa', 'tipe_coa'));
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
}
