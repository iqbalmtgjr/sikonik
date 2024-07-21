<!-- Modal -->
<div class="modal fade" id="klinik" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Pengguna Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pengguna.klinik') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="email2" id="email2">
                    <div class="mb-3">
                        <label for="klinik_id" class="form-label">Klinik</label>
                        <select class="form-select @error('klinik') is-invalid @enderror" id="klinik2" name="klinik">
                            <option value="">-- Pilih Klinik --</option>
                            @foreach ($klinik as $item)
                                <option value="{{ $item->id }}" {{ old('klinik') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_klinik }}
                                </option>
                            @endforeach
                        </select>
                        @error('klinik')
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
        function getdata2(id) {
            var url = '{{ url('/pengguna/getdata') }}' + '/' + id
            // console.log(url);
            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    console.log(data.dokter.klinik_id);
                    $('#email2').val(data.email);
                    if (data.dokter) {
                        $('#klinik2').val(data.dokter.klinik_id);
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
