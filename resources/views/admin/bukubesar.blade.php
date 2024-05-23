@extends('layouts.admin')
@section('content')
    <div class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Buku Besar </h4>
                            </div>
                            <div class="header-title">
                                <button class="btn btn-success btn-sm confirmPrintExcel" type="button" data-placement="top"
                                    title="Print COA" id="export-excel">
                                    Excel <i class="fa-solid fa-print"></i>
                                </button>
                                <button class="btn btn-primary text-white btn-sm confirmPrintPDF" data-placement="top"
                                    title="Print PDF" id="export-pdf">
                                    PDF <i class="fa-regular fa-file-zipper fa-lg"></i>
                                </button>
                            </div>

                        </div>
                        <div class="card-body">
                            <p>Images in Bootstrap are made responsive to the image so that it scales
                                with the parent element.</p>
                            <form method="GET" action="{{ route('bukubesar.filterDate') }}">
                                <div class="date-filter mb-2">
                                    <input type="date" name="start_date" value="{{ $start_date }}"
                                        placeholder="Start Date"> -
                                    <input type="date" name="end_date" value="{{ $end_date }}"placeholder="End Date">
                                    <button class="btn btn-primary btn-sm">Filter</button>
                                    <a href="/buku-besar" class="btn btn-secondary btn-sm">Reset</a>
                                </div>
                            </form>

                            <table id="datatable-1" class="table data-table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Keterangan</th>
                                        <th>Tipe Coa</th>
                                        <th>Tanggal</th>
                                        <th class="text-right">Debit</th>
                                        <th class="text-right">Credit</th>
                                        <th class="text-right">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cashflow as $item)
                                        <tr>
                                            <td>{{ $item->no_reff }}</td>
                                            <td>{{ $item->nama_akun }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->coa_name }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td class="text-right">{{ formatToIDR($item->debet) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->credit) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->saldo) }}</td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Kas</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatable-1" class="table data-table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Keterangan</th>
                                        <th>Tipe Coa</th>
                                        <th>Tanggal</th>
                                        <th class="text-right">Debit</th>
                                        <th class="text-right">Credit</th>
                                        <th class="text-right">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kas as $item)
                                        <tr>
                                            <td>{{ $item->coa->no_reff }}</td>
                                            <td>{{ $item->coa->nama_akun }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->coa->tipe_coa->name }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td class="text-right">{{ formatToIDR($item->debet) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->credit) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->saldo) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Piutang Usaha</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatable-1" class="table data-table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Keterangan</th>
                                        <th>Tipe Coa</th>
                                        <th>Tanggal</th>
                                        <th class="text-right">Debit</th>
                                        <th class="text-right">Credit</th>
                                        <th class="text-right">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($piutangUsaha as $item)
                                        <tr>
                                            <td>{{ $item->coa->no_reff }}</td>
                                            <td>{{ $item->coa->nama_akun }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->coa->tipe_coa->name }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td class="text-right">{{ formatToIDR($item->debet) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->credit) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->saldo) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Sewa Dimuka</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatable-1" class="table data-table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Keterangan</th>
                                        <th>Tipe Coa</th>
                                        <th>Tanggal</th>
                                        <th class="text-right">Debit</th>
                                        <th class="text-right">Credit</th>
                                        <th class="text-right">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sewaDimuka as $item)
                                        <tr>
                                            <td>{{ $item->coa->no_reff }}</td>
                                            <td>{{ $item->coa->nama_akun }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->coa->tipe_coa->name }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td class="text-right">{{ formatToIDR($item->debet) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->credit) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->saldo) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Asuransi Dimuka</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatable-1" class="table data-table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Keterangan</th>
                                        <th>Tipe Coa</th>
                                        <th>Tanggal</th>
                                        <th class="text-right">Debit</th>
                                        <th class="text-right">Credit</th>
                                        <th class="text-right">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($asuransiDimuka as $item)
                                        <tr>
                                            <td>{{ $item->coa->no_reff }}</td>
                                            <td>{{ $item->coa->nama_akun }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->coa->tipe_coa->name }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td class="text-right">{{ formatToIDR($item->debet) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->credit) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->saldo) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Sediaan Habis Pakai</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatable-1" class="table data-table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Keterangan</th>
                                        <th>Tipe Coa</th>
                                        <th>Tanggal</th>
                                        <th class="text-right">Debit</th>
                                        <th class="text-right">Credit</th>
                                        <th class="text-right">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sediaanHabisPakai as $item)
                                        <tr>
                                            <td>{{ $item->coa->no_reff }}</td>
                                            <td>{{ $item->coa->nama_akun }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->coa->tipe_coa->name }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td class="text-right">{{ formatToIDR($item->debet) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->credit) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->saldo) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Peralatan Salon</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatable-1" class="table data-table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Keterangan</th>
                                        <th>Tipe Coa</th>
                                        <th>Tanggal</th>
                                        <th class="text-right">Debit</th>
                                        <th class="text-right">Credit</th>
                                        <th class="text-right">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($peralatanSalon as $item)
                                        <tr>
                                            <td>{{ $item->coa->no_reff }}</td>
                                            <td>{{ $item->coa->nama_akun }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->coa->tipe_coa->name }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td class="text-right">{{ formatToIDR($item->debet) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->credit) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->saldo) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Hutang Usaha</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatable-1" class="table data-table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Keterangan</th>
                                        <th>Tipe Coa</th>
                                        <th>Tanggal</th>
                                        <th class="text-right">Debit</th>
                                        <th class="text-right">Credit</th>
                                        <th class="text-right">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hutangUsaha as $item)
                                        <tr>
                                            <td>{{ $item->coa->no_reff }}</td>
                                            <td>{{ $item->coa->nama_akun }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->coa->tipe_coa->name }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td class="text-right">{{ formatToIDR($item->debet) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->credit) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->saldo) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Hutang di Bank TOP</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatable-1" class="table data-table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Keterangan</th>
                                        <th>Tipe Coa</th>
                                        <th>Tanggal</th>
                                        <th class="text-right">Debit</th>
                                        <th class="text-right">Credit</th>
                                        <th class="text-right">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hutangBankTop as $item)
                                        <tr>
                                            <td>{{ $item->coa->no_reff }}</td>
                                            <td>{{ $item->coa->nama_akun }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->coa->tipe_coa->name }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td class="text-right">{{ formatToIDR($item->debet) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->credit) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->saldo) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Hutang Bank Maju</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatable-1" class="table data-table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Keterangan</th>
                                        <th>Tipe Coa</th>
                                        <th>Tanggal</th>
                                        <th class="text-right">Debit</th>
                                        <th class="text-right">Credit</th>
                                        <th class="text-right">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hutangBankMaju as $item)
                                        <tr>
                                            <td>{{ $item->coa->no_reff }}</td>
                                            <td>{{ $item->coa->nama_akun }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->coa->tipe_coa->name }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td class="text-right">{{ formatToIDR($item->debet) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->credit) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->saldo) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Uang Muka Member</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatable-1" class="table data-table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Keterangan</th>
                                        <th>Tipe Coa</th>
                                        <th>Tanggal</th>
                                        <th class="text-right">Debit</th>
                                        <th class="text-right">Credit</th>
                                        <th class="text-right">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($uangMukaMember as $item)
                                        <tr>
                                            <td>{{ $item->coa->no_reff }}</td>
                                            <td>{{ $item->coa->nama_akun }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->coa->tipe_coa->name }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td class="text-right">{{ formatToIDR($item->debet) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->credit) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->saldo) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Model Helena</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatable-1" class="table data-table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Keterangan</th>
                                        <th>Tipe Coa</th>
                                        <th>Tanggal</th>
                                        <th class="text-right">Debit</th>
                                        <th class="text-right">Credit</th>
                                        <th class="text-right">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($modelHelena as $item)
                                        <tr>
                                            <td>{{ $item->coa->no_reff }}</td>
                                            <td>{{ $item->coa->nama_akun }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->coa->tipe_coa->name }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td class="text-right">{{ formatToIDR($item->debet) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->credit) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->saldo) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Akumulasi Depresiasi</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatable-1" class="table data-table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Keterangan</th>
                                        <th>Tipe Coa</th>
                                        <th>Tanggal</th>
                                        <th class="text-right">Debit</th>
                                        <th class="text-right">Credit</th>
                                        <th class="text-right">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($akDepresiasi as $item)
                                        <tr>
                                            <td>{{ $item->coa->no_reff }}</td>
                                            <td>{{ $item->coa->nama_akun }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->coa->tipe_coa->name }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td class="text-right">{{ formatToIDR($item->debet) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->credit) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->saldo) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Hutang Gaji</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatable-1" class="table data-table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Keterangan</th>
                                        <th>Tipe Coa</th>
                                        <th>Tanggal</th>
                                        <th class="text-right">Debit</th>
                                        <th class="text-right">Credit</th>
                                        <th class="text-right">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hutangGaji as $item)
                                        <tr>
                                            <td>{{ $item->coa->no_reff }}</td>
                                            <td>{{ $item->coa->nama_akun }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->coa->tipe_coa->name }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td class="text-right">{{ formatToIDR($item->debet) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->credit) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->saldo) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Prive</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatable-1" class="table data-table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Keterangan</th>
                                        <th>Tipe Coa</th>
                                        <th>Tanggal</th>
                                        <th class="text-right">Debit</th>
                                        <th class="text-right">Credit</th>
                                        <th class="text-right">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($prive as $item)
                                        <tr>
                                            <td>{{ $item->coa->no_reff }}</td>
                                            <td>{{ $item->coa->nama_akun }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->coa->tipe_coa->name }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td class="text-right">{{ formatToIDR($item->debet) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->credit) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->saldo) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Pendapatan Non Member</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatable-1" class="table data-table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Keterangan</th>
                                        <th>Tipe Coa</th>
                                        <th>Tanggal</th>
                                        <th class="text-right">Debit</th>
                                        <th class="text-right">Credit</th>
                                        <th class="text-right">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pendapatanNonMember as $item)
                                        <tr>
                                            <td>{{ $item->coa->no_reff }}</td>
                                            <td>{{ $item->coa->nama_akun }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->coa->tipe_coa->name }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td class="text-right">{{ formatToIDR($item->debet) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->credit) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->saldo) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Pendapatan Member</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatable-1" class="table data-table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Keterangan</th>
                                        <th>Tipe Coa</th>
                                        <th>Tanggal</th>
                                        <th class="text-right">Debit</th>
                                        <th class="text-right">Credit</th>
                                        <th class="text-right">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pendapatanMember as $item)
                                        <tr>
                                            <td>{{ $item->coa->no_reff }}</td>
                                            <td>{{ $item->coa->nama_akun }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->coa->tipe_coa->name }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td class="text-right">{{ formatToIDR($item->debet) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->credit) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->saldo) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Biaya Gaji</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatable-1" class="table data-table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Keterangan</th>
                                        <th>Tipe Coa</th>
                                        <th>Tanggal</th>
                                        <th class="text-right">Debit</th>
                                        <th class="text-right">Credit</th>
                                        <th class="text-right">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($biayaGaji as $item)
                                        <tr>
                                            <td>{{ $item->coa->no_reff }}</td>
                                            <td>{{ $item->coa->nama_akun }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->coa->tipe_coa->name }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td class="text-right">{{ formatToIDR($item->debet) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->credit) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->saldo) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Biaya Asuransi</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatable-1" class="table data-table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Keterangan</th>
                                        <th>Tipe Coa</th>
                                        <th>Tanggal</th>
                                        <th class="text-right">Debit</th>
                                        <th class="text-right">Credit</th>
                                        <th class="text-right">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($biayaAsuransi as $item)
                                        <tr>
                                            <td>{{ $item->coa->no_reff }}</td>
                                            <td>{{ $item->coa->nama_akun }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->coa->tipe_coa->name }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td class="text-right">{{ formatToIDR($item->debet) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->credit) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->saldo) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Biaya Sewa</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatable-1" class="table data-table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Keterangan</th>
                                        <th>Tipe Coa</th>
                                        <th>Tanggal</th>
                                        <th class="text-right">Debit</th>
                                        <th class="text-right">Credit</th>
                                        <th class="text-right">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($biayaSewa as $item)
                                        <tr>
                                            <td>{{ $item->coa->no_reff }}</td>
                                            <td>{{ $item->coa->nama_akun }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->coa->tipe_coa->name }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td class="text-right">{{ formatToIDR($item->debet) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->credit) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->saldo) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Biaya Listrik, Air, Telepon</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatable-1" class="table data-table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Keterangan</th>
                                        <th>Tipe Coa</th>
                                        <th>Tanggal</th>
                                        <th class="text-right">Debit</th>
                                        <th class="text-right">Credit</th>
                                        <th class="text-right">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($biayaListrikEtc as $item)
                                        <tr>
                                            <td>{{ $item->coa->no_reff }}</td>
                                            <td>{{ $item->coa->nama_akun }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->coa->tipe_coa->name }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td class="text-right">{{ formatToIDR($item->debet) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->credit) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->saldo) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Biaya Depresiasi Peralatan</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatable-1" class="table data-table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Keterangan</th>
                                        <th>Tipe Coa</th>
                                        <th>Tanggal</th>
                                        <th class="text-right">Debit</th>
                                        <th class="text-right">Credit</th>
                                        <th class="text-right">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($biayaDepresiasiPeralatan as $item)
                                        <tr>
                                            <td>{{ $item->coa->no_reff }}</td>
                                            <td>{{ $item->coa->nama_akun }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->coa->tipe_coa->name }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td class="text-right">{{ formatToIDR($item->debet) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->credit) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->saldo) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Biaya Lain Lain</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatable-1" class="table data-table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Keterangan</th>
                                        <th>Tipe Coa</th>
                                        <th>Tanggal</th>
                                        <th class="text-right">Debit</th>
                                        <th class="text-right">Credit</th>
                                        <th class="text-right">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($biayaLainLain as $item)
                                        <tr>
                                            <td>{{ $item->coa->no_reff }}</td>
                                            <td>{{ $item->coa->nama_akun }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->coa->tipe_coa->name }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td class="text-right">{{ formatToIDR($item->debet) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->credit) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->saldo) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('script')
    <!-- jQuery and Bootstrap JS -->
    <script>
        $(document).ready(function() {
            $('.confirmPrintPDF').click(function(event) {
                event.preventDefault()
                var form = $(this).closest("form")
                Swal.fire({
                    title: 'Print PDF?',
                    text: 'Data ini akan di print.',
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route('bukubesar.export.pdf') }}'
                    }
                })
            })
            $('.confirmPrintExcel').click(function(event) {
                event.preventDefault()
                var form = $(this).closest("form")
                Swal.fire({
                    title: 'Print Excel?',
                    text: 'Data ini akan di print.',
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route('bukubesar.export.excel') }}'
                    }
                })
            })
        })
    </script>
@endsection
