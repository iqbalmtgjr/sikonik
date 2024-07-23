@extends('layouts.master')

@section('content')
    <div class="pagetitle">
        <h1>Janji Temu</h1>
    </div>

    @if (auth()->user()->role == 'pelanggan')
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            Harap tekan tombol <strong>Lihat Catatan Klinik</strong> pada kolom aksi apabila status <span
                class="badge bg-danger">Ditolak</span> ataupun <span class="badge bg-success">Diterima</span> untuk melihat
            catatan dari klinik
        </div>
    @endif

    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @if (auth()->user()->role == 'pelanggan')
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <i class="bi bi-person-plus-fill me-1"></i> Tambah Janji
                            </button>
                        @endif

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="myTable table table-hover table-lg">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Pengaju</th>
                                            <th>Jenis Hewan</th>
                                            <th>Keluhan</th>
                                            <th>Waktu</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($janji as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->user->name }}</td>
                                                <td>{{ $item->jenis_hewan }}</td>
                                                <td>{{ $item->keluhan_hewan }}</td>
                                                <td>{{ date('d-m-Y H:i', strtotime($item->waktu)) }}</td>
                                                <td>
                                                    <span
                                                        class="badge {{ $item->status == 'Diterima' ? 'bg-success' : ($item->status == 'Ditolak' ? 'bg-danger' : 'bg-warning') }}">
                                                        {{ $item->status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="#qwe" onclick="getdata2({{ $item->id }})"
                                                        data-bs-toggle="modal"
                                                        class="btn btn-success btn-sm">{{ auth()->user()->role == 'pelanggan' ? 'Lihat Catatan Klinik' : 'Tambah Catatan' }}</a>
                                                    <a href="#edit" onclick="getdata({{ $item->id }})"
                                                        data-bs-toggle="modal" class="btn btn-primary btn-sm">Edit</a>
                                                    @if (Auth::user()->role != 'pelanggan')
                                                        <a href="javascript:void(0)" class="btn btn-danger btn-sm delete"
                                                            data-id="{{ $item->id }}">Hapus</a>
                                                    @endif
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
    @include('janjitemu.modal')
    @include('janjitemu.modaledit')
    @include('janjitemu.modalcatatan')
@endsection

@push('script')
    <script>
        $('.myTable').on('click', '.delete', function() {
            let data = $(this).data()
            // let Nama = data.nama;
            let Id = data.id;
            console.log(Id)
            Swal.fire({
                title: 'Apakah Anda Yakin Menghapus Data Ini?',
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
                        url: `{{ url('/janjitemu/delete') }}/${Id}`,
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
