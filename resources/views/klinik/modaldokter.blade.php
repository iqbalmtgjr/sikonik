<!-- Modal -->
<div class="modal fade" id="dokter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Modified here to make modal larger -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Daftar Dokter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="myTable table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Dokter</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dokter as $item)
                            <tr>
                                <td>{{ $item->user->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="dokter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Klinik</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('klinik') }}" method="get">
                    @csrf
                    <input type="hidden" name="id" id="id">
                </form>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Dokter</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dokter as $item)
                            <tr>
                                <td>{{ $item->nama_dokter }}</td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-sm">Tambah</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@push('script')
    <script>
        function getdata2(id) {
            // var url = '{{ url('/klinik/getdata') }}' + '/' + id
            // console.log(url);
            // $('#id').val(data.id);

            $.ajax({
                // url: '{{ url('klinik/getdata') }}/' + id,
                url: '{{ url('klinik') }}',
                method: 'GET',
                data: {
                    id_klinik: id,
                },
                success: function(data) {
                    $('#id').val(data.id_klinik);
                    $('#id').val(data.id);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                    alert('Error');
                }
            });

        }
    </script>
@endpush
