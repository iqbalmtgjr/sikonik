@extends('layouts.master')

@section('content')
    <div class="pagetitle">
        <h1>Data Klinik & Dokter</h1>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @if (auth()->user()->role == 'admin')
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <i class="bi bi-person-plus-fill me-1"></i> Tambah Klinik
                            </button>
                        @endif

                        @include('klinik.modal')
                        @include('klinik.modaldokter')
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="myTable table table-hover table-lg">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>No Telepon</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($klinik as $klinik)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $klinik->nama_klinik }}</td>
                                                <td>{{ $klinik->alamat }}</td>
                                                <td>{{ $klinik->no_telp }}</td>
                                                <td>
                                                    <a href="#dokter" onclick="getdata2({{ $klinik->id }})"
                                                        data-bs-toggle="modal" class="btn btn-success btn-sm">Lihat
                                                        Dokter</a>
                                                    @if (Auth::user()->role == 'admin' || auth()->user()->role == 'admin_klinik')
                                                        <a href="#edit" onclick="getdata({{ $klinik->id }})"
                                                            data-bs-toggle="modal" data-id="{{ $klinik->id }}"
                                                            class="btn btn-primary btn-sm">Edit</a>
                                                    @endif
                                                    <a href="javascript:void(0)" class="btn btn-danger btn-sm delete"
                                                        data-nama="{{ $klinik->nama_klinik }}"
                                                        data-id="{{ $klinik->id }}">Hapus</a>
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
    @include('klinik.modaledit')
@endsection

@push('script')
    <script>
        $('.myTable').on('click', '.delete', function() {
            let data = $(this).data()
            let Nama = data.nama;
            let Id = data.id;
            console.log(Id)
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
                        url: `{{ url('/klinik/delete') }}/${Id}`,
                        method: 'GET',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            window.location.reload();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(errorThrown);
                            alert('Error');
                        }
                    });
                }
            });
        });
    </script>
@endpush
