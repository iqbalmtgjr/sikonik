<!-- Modal -->
<div class="modal fade" id="valid" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Validasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('transaksi.update') }}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="id">
                    <div class="mb-3">
                        <select class="form-control" name="validasi" id="validasi">
                            <option value="">-- Pilih Validasi --</option>
                            <option value="Menunggu">Menunggu</option>
                            <option value="Tidak Valid">Tidak Valid</option>
                            <option value="Valid">Valid</option>
                        </select>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
@push('script')
    <script>
        function getdata(id) {
            var url = '{{ url('/transaksi/getdata') }}' + '/' + id
            // console.log(url);
            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    console.log(data);
                    $('#id').val(data.id);
                    $('#validasi').val(data.status);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                    alert('Error ' + errorThrown);
                }
            });
        };
    </script>
@endpush
