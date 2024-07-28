<div>
    <section class="section">
        <h5 class="card-title">Pilih Dokter</h5>
        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-body d-flex flex-column">
                        <h6 class="mt-3 text-center text-primary text-uppercase text-lg"><strong>Pilih
                                Dokter</strong>
                        </h6>
                        <div class="list-group p-5">
                            @foreach ($dokter as $item)
                                <a href="javascript:void(0)" class="list-group-item list-group-item-action"
                                    wire:click="selectDokter({{ $item->klinik_id }},{{ $item->id }})">
                                    {{ $item->user->name }} - {{ $item->klinik->nama_klinik }}
                                    <span
                                        class="badge {{ $item->user->is_online ? 'bg-success' : 'bg-danger' }} float-end">{{ $item->user->is_online ? 'online' : 'offline' }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
