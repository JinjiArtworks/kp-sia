@extends('layouts.admin')
@section('content')
    <div class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Daftar COA </h4>
                            </div>
                            <div class="header-action">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                    data-target=".modal-coa">Tambah Coa</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p>Images in Bootstrap are made responsive to the image so that it scales
                                with the parent element.</p>
                            <div class="table-responsive">
                                <table id="datatable-1" class="table data-table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No Reff</th>
                                            <th>Nama Akun</th>
                                            <th>Akun Coa</th>
                                            <th class="text-right">Saldo</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($coa as $item)
                                            <tr>
                                                <td>{{ $item->no_reff }}</td>
                                                <td>{{ $item->nama_akun }}</td>
                                                <td>{{ $item->tipe_coa->name }}</td>
                                                <td class="text-right">{{ formatToIDR($item->saldo) }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        {{-- <button class="btn btn-primary btn-sm mr-1" type="button"
                                                            data-toggle="tooltip" data-placement="top" title="Detail COA">
                                                            <i class="fa-solid fa-book"></i>
                                                        </button> --}}
                                                        {{-- <button class="btn btn-success btn-sm mr-1 confirmPrintExcel"
                                                            type="button" data-placement="top" title="Print COA"
                                                            id="export-excel">
                                                            <i class="fa-solid fa-print"></i>
                                                        </button>
                                                        <button
                                                            class="btn btn-primary text-white btn-sm mr-1 confirmPrintPDF"
                                                            data-placement="top" title="Print PDF" id="export-pdf">
                                                            <i class="fa-regular fa-file-zipper fa-lg">
                                                            </i>
                                                        </button> --}}
                                                        <button class="btn btn-warning btn-sm mr-1" type="button"
                                                            data-toggle="modal" data-target=".modal-edit-coa"
                                                            data-id="{{ $item->id }}" data-nama="{{ $item->nama_akun }}"
                                                            data-saldo_coa="{{ $item->saldo }}"
                                                            data-no_reff="{{ $item->no_reff }}"
                                                            data-tipe_coa="{{ $item->tipe_coa_id }}" data-placement="top"
                                                            title="Edit COA">
                                                            <i class="fa-solid fa-pencil"></i>
                                                        </button>
                                                        <form method="GET"
                                                            action="{{ route('coa.delete-coa', ['id' => $item->id]) }}">
                                                            <button type="submit"
                                                                class="confirmDelete btn btn-sm btn-danger">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No Reff</th>
                                            <th>Nama Akun</th>
                                            <th>Tipe Coa</th>
                                            <th class="text-right">Saldo</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade modal-coa" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Coa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('coa.store-coa') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group ">
                                <input type="number" class="form-control" name="no_reff" placeholder="Nomor Reff">
                            </div>
                            <div class="form-group ">
                                <input type="text" class="form-control" name="nama_akun" placeholder="Nama Akun">
                            </div>
                            <div class="form-group ">
                                <input type="number" class="form-control" name="saldo_coa" placeholder="Saldo Coa">
                            </div>
                            <select class="form-control choicesjs" id="editTipeCoa" name="tipe_coa">
                                <option value=""> -- Select Coa -- </option>
                                @foreach ($tipe_coa as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm close-modal">Close</button>
                            <button type="button" class="btn btn-primary btn-sm confirm-add">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit COA Modal -->
        <div class="modal fade modal-edit-coa" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="editCoaForm" method="POST" action="{{ route('coa.update-coa') }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit COA</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="editCoaId">
                            <div class="form-group">
                                <input type="number" class="form-control" id="editNoReff" name="no_reff"
                                    placeholder="Nomor Reff" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="editNamaCoa" name="nama_akun"
                                    placeholder="Nama Akun" required>
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control" id="editSaldoCoa" name="saldo_coa"
                                    placeholder="Saldo Coa" required>
                            </div>
                            <div class="form-group">
                                <select class="form-control choicesjs" id="editTipeCoa" name="tipe_coa">
                                    <option value=""> -- Select Coa -- </option>
                                    @foreach ($tipe_coa as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
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
                $('.modal-coa').modal('hide')
            })
            // Modal edit
            $('.modal-edit-coa').on('show.bs.modal', function(event) {
                var target = $(event.relatedTarget)
                var id = target.data('id')
                var nama = target.data('nama')
                var saldo_coa = target.data('saldo_coa')
                var tipe_coa = target.data('tipe_coa')
                var no_reff = target.data('no_reff') // diambil dari parmas data-xxx
                var modal = $(this)
                modal.find('#editCoaId').val(id)
                modal.find('#editNamaCoa').val(nama)
                modal.find('#editSaldoCoa').val(saldo_coa)
                modal.find('#editNoReff').val(no_reff)
                // modal.find('#editTipeCoa').val(tipe_coa)
                modal.find('#editTipeCoa option[value="' + tipe_coa + '"]').prop('selected', true);
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
                        window.location.href = '{{ route('coa.export.pdf') }}'
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
                        window.location.href = '{{ route('coa.export.excel') }}'
                    }
                })
            })
        })
    </script>
@endsection
