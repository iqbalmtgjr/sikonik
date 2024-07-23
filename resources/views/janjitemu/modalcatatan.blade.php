<!-- Modal -->
<div class="modal fade" id="qwe" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Catatan Dari Klinik</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('janjitemu.catatan') }}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="idd" id="idd">
                    <div class="mb-3">
                        <textarea {{ auth()->user()->role == 'pelanggan' ? 'disabled' : '' }} class="form-control" rows="5" name="catatan"
                            id="catatannya"
                            placeholder="{{ auth()->user()->role == 'pelanggan' ? 'Tidak ada catatan dari klinik' : 'Masukkan catatan dari klinik' }}"></textarea>
                    </div>
                    @if (auth()->user()->role != 'pelanggan')
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    @endif
            </div>
            </form>
        </div>
    </div>
</div>
</div>
@push('script')
    <script>
        function getdata2(id) {
            var url = '{{ url('/janjitemu/getdata2') }}' + '/' + id
            // console.log(url);
            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    // console.log(data);
                    $('#idd').val(data.id);
                    $('#catatannya').val(data.catatan);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                    alert('Error ' + errorThrown);
                }
            });
        };
    </script>
@endpush
