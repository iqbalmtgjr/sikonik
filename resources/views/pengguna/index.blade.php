@extends('layouts.master')

@section('content')
    <div class="pagetitle">
        <h1>Kelola Pengguna</h1>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            <i class="bi bi-person-plus-fill me-1"></i> Tambah Pengguna
                        </button>

                        @include('pengguna.modal')
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="myTable" class="table table-hover table-lg">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Roles</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->role }}</td>
                                                <td>
                                                    <a href="#edit" onclick="getdata({{ $user->id }})"
                                                        data-bs-toggle="modal" data-id="{{ $user->id }}"
                                                        class="btn btn-primary btn-sm">Edit</a>
                                                    <a href="javascript:void(0)" class="btn btn-danger btn-sm delete"
                                                        onclick="hapusData({{ $user->id }})"
                                                        data-nama="{{ $user->name }}">Hapus</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    @include('pengguna.modaledit')
@endsection

@push('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.0/css/dataTables.dataTables.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.3/dist/sweetalert2.min.css" rel="stylesheet">
@endpush
@push('script')
    <script>
        $('#myTable').on('click', '.delete', function() {
            let Nama = $(this).data().nama;
            Swal.fire({
                title: 'Apakah Anda Yakin Menghapus Data ' + Nama + '?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus Data!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url('pengguna') }}/' + id,
                        type: 'DELETE',
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status == 'success') {
                                Swal.fire(
                                    'Terhapus!',
                                    'Data berhasil dihapus.',
                                    'success'
                                );
                            } else {
                                Swal.fire(
                                    'Gagal!',
                                    'Data gagal dihapus.',
                                    'error'
                                );
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush
