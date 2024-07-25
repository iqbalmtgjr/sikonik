@extends('layouts.master')

@section('content')
    <div class="pagetitle">
        <h1>Transaksi</h1>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        {{-- <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            <i class="bi bi-person-plus-fill me-1"></i> Tambah 
                        </button> --}}

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="myTable table table-hover table-lg">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Pelanggan</th>
                                            <th>Harga</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->user->name }}</td>
                                                <td>Rp. {{ number_format($item->harga, 0, ',', '.') }}</td>
                                                <td>
                                                    <span
                                                        class="badge {{ $item->status == 'Valid' ? 'bg-success' : ($item->status == 'Tidak Valid' ? 'bg-danger' : 'bg-warning') }}">
                                                        {{ $item->status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="#valid" onclick="getdata({{ $item->id }})"
                                                        data-bs-toggle="modal" class="btn btn-primary btn-sm">Validasi</a>
                                                    <a href="javascript:void(0)" class="btn btn-danger btn-sm delete"
                                                        data-id="{{ $item->id }}">Hapus</a>
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
    @include('transaksi.modalvalid')
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
