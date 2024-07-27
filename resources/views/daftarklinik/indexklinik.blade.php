@extends('layouts.master')

@section('content')
<div class="row">
    @foreach ($klinik as $klinik)
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                <h5 class="card-title">{{ $klinik->nama_klinik }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">{{ $klinik->alamat }}</h6>
                <p class="card-text">{{ $klinik->deskripsi }}</p>
                {{-- <p class="card-text"><a href="#" class="btn btn-primary">Button</a></p> --}}
                <a href="{{ url('konsultasi') }}" class="btn btn-sm btn-success">Konsultasi</a>
                <a href="{{ url('janjitemu') }}" class="btn btn-sm btn-primary">Janjian</a>
                <a href="#dokter" onclick="getdata2({{ $klinik->id }})"
                    data-bs-toggle="modal" class="btn btn-warning btn-sm">Dokter</a>
                </div>
            </div>
        </div>
    @endforeach 
</div>
@include('klinik.modaledit')
@include('klinik.modaldokter')
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
