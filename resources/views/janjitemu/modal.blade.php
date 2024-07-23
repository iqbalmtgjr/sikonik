<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Janji</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('janjitemu.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Klinik</label>
                        <select class="form-select" name="nama_klinik">
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
                            name="jenis_hewan" placeholder="Masukkan jenis hewan">
                        @error('jenis_hewan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keluhan Hewan</label>
                        <input type="text" class="form-control @error('keluhan_hewan') is-invalid @enderror"
                            name="keluhan_hewan" placeholder="Masukkan keluhan hewan">
                        @error('keluhan_hewan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal dan Jam Janji</label>
                        <input type="datetime-local" class="form-control @error('waktu') is-invalid @enderror"
                            name="waktu" placeholder="Masukkan tanggal dan waktu">
                        @error('waktu')
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
