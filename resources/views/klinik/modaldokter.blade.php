<!-- Modal -->
<div class="modal fade" id="dokter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Modified here to make modal larger -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Daftar Dokter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="dokter_list" class="table-responsive fv-row mb-4"></div>
            </div>
        </div>
    </div>
</div>
@push('script')
    <script>
        function getdata2(id) {
            $.ajax({
                url: '{{ url('klinik/getdata2') }}/' + id,
                method: 'GET',
                cache: false,
                success: function(response) {
                    // console.log(response);
                    tampilkanDataDokter(response);
                    // tampilkanDataDokter({
                    //     dokter: []
                    // });
                }
            });
        }

        function tampilkanDataDokter(response) {
            var dokterList = '';
            if (response.length > 0) {
                dokterList += '<table class="myTable table table-hover table-lg">';
                dokterList +=
                    '<thead><tr><th style="width: 10px;">No</th><th style="width: 200px;">Dokter</th></tr></thead>';
                dokterList += '<tbody>';
                response.forEach(function(list, index) {
                    dokterList += '<tr><td>' + (index + 1) + '</td><td>' + list.user.name +
                        '</td>';
                });
                dokterList += '</tbody></table>';
            } else {
                dokterList = '<div>Belum ada dokter diklinik ini</div>';
            }
            $('#dokter_list').html(dokterList);
        }
    </script>
@endpush
