<!-- Modal -->
<div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ubah Data Janji</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('janjitemu.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="id">
                    <div class="mb-3">
                        <label class="form-label">Nama Klinik</label>
                        <select class="form-select" name="nama_klinik" id="nama_klinik">
                            <option value="">-- Pilih Klinik --</option>
                            @foreach ($klinik as $klinik)
                                <option value="{{ $klinik->id }}">{{ $klinik->nama_klinik }}</option>
                            @endforeach
                        </select>
                        @error('nama_klinik')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Hewan</label>
                        <input type="text" class="form-control @error('jenis_hewan') is-invalid @enderror"
                            name="jenis_hewan" id="jenis_hewan" placeholder="Masukkan jenis hewan">
                        @error('jenis_hewan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keluhan Hewan</label>
                        <input type="text" class="form-control @error('keluhan_hewan') is-invalid @enderror"
                            name="keluhan_hewan" id="keluhan_hewan" placeholder="Masukkan keluhan hewan">
                        @error('keluhan_hewan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal dan Jam Janji</label>
                        <input type="datetime-local" class="form-control @error('waktu') is-invalid @enderror"
                            name="waktu" id="waktu" placeholder="Masukkan tanggal dan waktu">
                        @error('waktu')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    @if (Auth::user()->role != 'pelanggan')
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status"
                                id="status">
                                <option value="">-- Pilih Status --</option>
                                <option value="Menunggu">Menunggu</option>
                                <option value="Diterima">Diterima</option>
                                <option value="Ditolak">Ditolak</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    @endif
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
            var url = '{{ url('/janjitemu/getdata') }}' + '/' + id
            console.log(url);
            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    // console.log(data);
                    $('#id').val(data.id);
                    $('#nama_klinik').val(data.klinik_id);
                    $('#jenis_hewan').val(data.jenis_hewan);
                    $('#keluhan_hewan').val(data.keluhan_hewan);
                    $('#waktu').val(data.waktu);
                    $('#status').val(data.status);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // console.log(errorThrown);
                    alert('Error ' + errorThrown);
                }
            });
        };
    </script>
@endpush
