@extends('layouts.admin')
@section('content')
    <div class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Neraca </h4>
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
                            <form method="GET" action="{{ route('neraca.filterDate') }}">
                                <div class="date-filter mb-2">
                                    <input type="date" name="start_date" value="{{ $start_date }}"
                                        placeholder="Start Date"> -
                                    <input type="date" name="end_date" value="{{ $end_date }}"placeholder="End Date">
                                    <button class="btn btn-primary btn-sm">Filter</button>
                                    <a href="/data-neraca" class="btn btn-secondary btn-sm">Reset</a>
                                </div>
                            </form>

                            <table id="datatable-1" class="table data-table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Akun</th>
                                        <th>Keterangan</th>
                                        <th>Tanggal</th>
                                        <th class="text-right">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cashflow as $item)
                                        <tr>
                                            <td>{{ $item->nama_akun }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td class="text-right">{{ formatToIDR($item->saldo) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Nama Akun</th>
                                        <th>Keterangan</th>
                                        <th>Tanggal</th>
                                        <th class="text-right">Saldo</th>
                                    </tr>
                                </tfoot>
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
                        window.location.href = '{{ route('neraca.export.pdf') }}'
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
                        window.location.href = '{{ route('neraca.export.excel') }}'
                    }
                })
            })
        })
    </script>
@endsection
