<!-- Modal -->
<div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Pengguna Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pengguna.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                            name="nama" placeholder="Masukkan nama">
                        @error('nama')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" placeholder="Masukkan email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nomor_telepon" class="form-label">No Telepon</label>
                        <input type="number" class="form-control @error('nomor_telepon') is-invalid @enderror"
                            id="nomor_telepon" name="nomor_telepon" placeholder="Masukkan no telepon">
                        @error('nomor_telepon')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat"
                            placeholder="Masukkan alamat"></textarea>
                        @error('alamat')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('script')
    <script>
        function getdata(id) {
            var url = '{{ url('/pengguna/getdata') }}' + '/' + id
            console.log(url);
            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    // console.log(data);
                    $('#nama').val(data.name);
                    $('#email').val(data.email);
                    if (data.pelanggan) {
                        $('#alamat').val(data.pelanggan.alamat);
                        $('#nomor_telepon').val(data.pelanggan.no_telp);
                    } else {
                        $('#alamat').val(data.dokter.alamat);
                        $('#nomor_telepon').val(data.dokter.no_telp);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                    alert('Error');
                }
            });
        };
    </script>
@endpush
