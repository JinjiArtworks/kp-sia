<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CashFlowExport;
use App\Exports\CoaExport;
use App\Http\Controllers\Controller;
use App\Models\BukuBesar;
use App\Models\CashFlow;
use App\Models\Coa;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Mpdf\Mpdf;

class UserController extends Controller
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
        $user = User::all();
        return view('admin.user', compact('user', 'start_date', 'end_date'));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => 'Admin',
            'password' => Hash::make($request->password),
        ]);
        return redirect('/data-user')->with('success', 'coa berhasil ditambahkan');
    }
    public function update(Request $request)
    {
        User::where('id', $request->id)
            ->update(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => Hash::make($request->password),
                ]
            );
        return redirect('/data-user')->with('success', 'coa berhasil diubah');
    }
    public function destroy($id)
    {
        User::where('id', $id)->delete();
        return redirect()->back();
    }
}
