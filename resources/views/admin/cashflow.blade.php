@extends('layouts.admin')
@section('content')
    <div class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Daftar Cashflow </h4>
                            </div>
                            <div class="header-action">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                    data-target=".modal-cashflow">Tambah Cashflow</button>
                                <button class="btn btn-success btn-sm mr-1 confirmPrintExcel" type="button"
                                    data-placement="top" title="Print COA" id="export-excel">
                                    Excel <i class="fa-solid fa-print"></i>
                                </button>
                                <button class="btn btn-primary text-white btn-sm mr-1 confirmPrintPDF" data-placement="top"
                                    title="Print PDF" id="export-pdf">
                                    PDF <i class="fa-regular fa-file-zipper fa-lg"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p>Images in Bootstrap are made responsive to the image so that it scales
                                with the parent element.</p>
                            <form method="GET" action="{{ route('cashflow.filterDate') }}">
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
                                        <th>Nama</th>
                                        <th class="text-right">Credit</th>
                                        <th class="text-right">Debit</th>
                                        <th class="text-right">Saldo</th>
                                        <th>Remarks</th>
                                        <th>Date</th>
                                        <th>Nama Coa</th>
                                        <th>Dibuat Oleh</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cashflow as $key => $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td class="text-right">{{ formatToIDR($item->credit) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->debet) }}</td>
                                            <td class="text-right">{{ formatToIDR($item->saldo) }}</td>
                                            <td>{{ $item->remarks }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td>{{ $item->coa->nama_akun }}</td>
                                            <td>{{ $item->users->name }}</td>
                                            <td>
                                                <div class="d-flex">
                                                   
                                                    @if ($key == count($cashflow) - 1)
                                                        <button class="btn btn-warning btn-sm mr-1" type="button"
                                                            data-toggle="modal" data-target=".modal-edit-cashflow"
                                                            data-id="{{ $item->id }}" data-nama="{{ $item->name }}"
                                                            data-credit="{{ $item->credit }}"
                                                            data-debet="{{ $item->debet }}" {{-- data-saldo="{{ $item->saldo }}" --}}
                                                            data-remarks="{{ $item->remarks }}"
                                                            data-date="{{ $item->date }}"
                                                            data-coa_id="{{ $item->coa_id }}" data-placement="top"
                                                            title="Edit Cashflow">
                                                            <i class="fa-solid fa-pencil"></i>
                                                        </button>
                                                        <form method="GET"
                                                            action="{{ route('cashflow.delete', ['id' => $item->id]) }}">
                                                            <button type="submit"
                                                                class="confirmDelete btn btn-sm btn-danger">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Credit</th>
                                        <th>Debit</th>
                                        <th class="text-right">Saldo</th>
                                        <th>Remarks</th>
                                        <th>Date</th>
                                        <th>Nama Coa</th>
                                        <th>Dibuat Oleh</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade modal-cashflow" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Cashflow</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('cashflow.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" placeholder="Nama">
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control" name="credit" placeholder="Credit">
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control" name="debet" placeholder="Debet">
                            </div>

                            <div class="form-group">
                                <textarea class="form-control" name="remarks" placeholder="Remarks"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="date" class="form-control" name="date" placeholder="Saldo Coa">
                            </div>
                            <select class="form-control choicesjs" id="coa-select" name="coa_id">
                                <option value="z"> -- Select Coa -- </option>
                                @foreach ($coa as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->nama_akun }} - {{ formatToIDR($item->saldo) }}</option>
                                @endforeach
                            </select>
                            {{-- <div class="form-group">
                                <input type="number" class="form-control" name="saldo" id="saldo-input" readonly
                                    placeholder="Saldo">
                            </div> --}}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm close-modal">Close</button>
                            <button type="button" class="btn btn-primary btn-sm confirm-add">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade modal-edit-cashflow" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="editCashFlowForm" method="POST" action="{{ route('cashflow.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Cash Flow</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="editCashFlowId">
                            <input type="hidden" name="coa_id" id="editCoaId">
                            <div class="form-group">
                                <input type="text" class="form-control" id="editNameCashflow" name="name"
                                    placeholder="Nama">
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control" id="editCredit" name="credit"
                                    placeholder="Credit">
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control" id="editDebet" name="debet"
                                    placeholder="Debet">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="remarks" id="editRemarks" placeholder="Remarks"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="date" class="form-control" id="editDate" name="date"
                                    placeholder="Saldo Coa">
                            </div>
                            {{-- <select class="form-control choicesjs" id="coa-select" name="coa_id">
                                <option value=""> -- Select Coa -- </option>
                                @foreach ($coa as $item)
                                    <option value="{{ $item->id }}" data-saldo="{{ $item->saldo }}">
                                        {{ $item->nama_akun }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-group">
                                <input type="number" class="form-control" name="saldo" id="saldo-input" readonly
                                    placeholder="Saldo">
                            </div> --}}
                            <!-- Add more fields as needed -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm close-modal"
                                data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-sm confirm-update">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('script')
    <!-- jQuery and Bootstrap JS -->
    <script>
        $(document).ready(function() {

            // Add click event listener to all buttons with the class "close-modal"
            $('.close-modal').click(function() {
                $('.modal-cashflow').modal('hide')
            })
            // Modal edit
            $('.modal-edit-cashflow').on('show.bs.modal', function(event) {
                var target = $(event.relatedTarget)
                var id = target.data('id')
                var nama = target.data('nama')
                var credit = target.data('credit')
                var debet = target.data('debet')
                // var saldo = target.data('saldo')
                var remarks = target.data('remarks')
                var date = target.data('date')
                var coa_id = target.data('coa_id')
                // -------------------------------
                var modal = $(this)
                modal.find('#editCashFlowId').val(id)
                modal.find('#editNameCashflow').val(nama)
                modal.find('#editCredit').val(credit)
                modal.find('#editDebet').val(debet)
                // modal.find('#editSaldo').val(saldo)
                modal.find('#editRemarks').val(remarks)
                modal.find('#editDate').val(date)
                modal.find('#editCoaId').val(coa_id)
                // modal.find('#editTipeCoa').val(tipe_coa)
            })
            // Confirmation Button
            $('.confirmDelete').click(function(event) {
                event.preventDefault()
                var form = $(this).closest("form")
                Swal.fire({
                    title: 'Hapus Data?',
                    text: 'Data ini akan terhapus secara permanen',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit()
                    }
                })
            })

            $('.confirm-update').click(function(event) {
                event.preventDefault()
                var form = $(this).closest("form")
                Swal.fire({
                    title: 'Konfirmasi Data?',
                    text: 'Pastikan data yang anda masukkan sudah benar',
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit()
                    }
                })
            })


            $('.confirm-add').click(function(event) {
                // if ($("input[name='name']").val() === '' ||
                //     $("input[name='credit']").val().trim().length === 0 ||
                //     $("input[name='debet']").val().trim().length === 0 ||
                //     $("input[name='date']").val() === '' ||
                //     $("input[name='coa_id']").val() === '') {
                //     Swal.fire({
                //         icon: "error",
                //         title: "Oops...",
                //         text: "Please fill all the fields.",
                //         confirmButtonColor: "#ea6a12",
                //     })
                //     return false; // prevent form submission
                // } else {
                event.preventDefault()
                var form = $(this).closest("form")
                Swal.fire({
                    title: 'Konfirmasi Data?',
                    text: 'Pastikan data yang anda masukkan benar',
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit()
                    }
                })
                // }


            })
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
                        window.location.href = '{{ route('cashflow.export.pdf') }}'
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
                        window.location.href = '{{ route('cashflow.export.excel') }}'
                    }
                })
            })
        })
    </script>
@endsection
