<!-- Modal -->
<div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Klinik</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('klinik.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="id">
                    <div class="mb-3">
                        <label class="form-label">Nama Klinik</label>
                        <input type="text" class="form-control @error('nama_klinik') is-invalid @enderror"
                            name="nama_klinik" id="nama_klinik" placeholder="Masukkan nama klinik">
                        @error('nama_klinik')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No Telepon</label>
                        <input type="number" class="form-control @error('nomor_telepon') is-invalid @enderror"
                            name="nomor_telepon" id="nomor_telepon" placeholder="Masukkan no telepon">
                        @error('nomor_telepon')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea rows="4" class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat"
                            placeholder="Masukkan alamat"></textarea>
                        @error('alamat')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea rows="4" class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi"
                            placeholder="Masukkan deskripsi"></textarea>
                        @error('deskripsi')
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
            var url = '{{ url('/klinik/getdata') }}' + '/' + id
            console.log(url);
            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    // console.log(data);
                    $('#id').val(data.id);
                    $('#nama_klinik').val(data.nama_klinik);
                    $('#nomor_telepon').val(data.no_telp);
                    $('#alamat').val(data.alamat);
                    $('#deskripsi').val(data.deskripsi);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                    alert('Error');
                }
            });
        };
    </script>
@endpush
