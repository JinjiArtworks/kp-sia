@extends('layouts.admin')
@section('content')
    <div class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Daftar user </h4>
                            </div>
                            <div class="header-action">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                    data-target=".modal-user">Tambah user</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p>Images in Bootstrap are made responsive to the image so that it scales
                                with the parent element.</p>
                            <table id="datatable-1" class="table data-table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Role</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->role }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <button class="btn btn-warning btn-sm mr-1" type="button"
                                                        data-toggle="modal" data-target=".modal-edit-user"
                                                        data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                                        data-password="{{ $item->password }}"
                                                        data-email="{{ $item->email }}" data-phone="{{ $item->phone }}"
                                                        data-placement="top" title="Edit user">
                                                        <i class="fa-solid fa-pencil"></i>
                                                    </button>
                                                    <form method="GET"
                                                        action="{{ route('user.delete', ['id' => $item->id]) }}">
                                                        <button type="submit" class="confirmDelete btn btn-sm btn-danger">
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
                                        <th>Name</th>
                                        <th>Role</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade modal-user" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah user</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" placeholder="Nama">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="email" name="email" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="password" name="password" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control" name="phone" placeholder="Nomor Handphone">
                            </div>
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

        <div class="modal fade modal-edit-user" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="edituserForm" method="POST" action="{{ route('user.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="editUserId">
                            <div class="form-group">
                                <input type="text" class="form-control" id="editName" name="name"
                                    placeholder="Nama">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="email" id="editEmail" name="email"
                                    placeholder="Email">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="password" id="editPassword"name="password"
                                    placeholder="Password">
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control" id="editPhone" name="phone"
                                    placeholder="Nomor Handphone">
                            </div>
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
                $('.modal-user').modal('hide')
            })
            // Modal edit
            $('.modal-edit-user').on('show.bs.modal', function(event) {
                var target = $(event.relatedTarget)
                // geting target from data on button edit
                var id = target.data('id')
                var name = target.data('name')
                var password = target.data('password')
                var phone = target.data('phone')
                var email = target.data('email')
                // -------------------------------
                var modal = $(this)
                modal.find('#editUserId').val(id)
                modal.find('#editName').val(name)
                modal.find('#editPassword').val(password)
                modal.find('#editPhone').val(phone)
                modal.find('#editEmail').val(email)
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
        })
    </script>
@endsection
