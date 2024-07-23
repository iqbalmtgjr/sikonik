<div>
    <div class="pagetitle">
        <h1>Konsultasi</h1>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mt-4 mb-3">
                            <h5>Chat Konsultasi</h5>
                            <hr>
                        </div>
                        <div class="mt-4" wire:poll>
                            @foreach ($konsultasi as $item)
                                @if ($item->user_id == auth()->user()->id)
                                    <div class="d-flex justify-content-end mb-3">
                                        <div class="bg-primary text-white p-2 rounded">
                                            {{ $item->chat }}
                                        </div>
                                    </div>
                                @else
                                    <div class="d-flex justify-content-start mb-3">
                                        <div class="bg-secondary text-white p-2 rounded">
                                            {{ $item->chat }}
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="mt-3">
                            <hr>
                            <form wire:submit="kirim" onsubmit="event.target.chat.blur()">
                                <div class="row">
                                    <div class="col-11">
                                        <input type="text" class="form-control" placeholder="Tulis pesan disini..."
                                            wire:model.debounce.500ms="chat"
                                            onkeydown="if (event.key === 'Enter') this.form.kirim()">
                                    </div>
                                    <div class="col-1 d-flex align-items-center">
                                        <button type="submit" class="btn btn-primary ms-auto">Kirim</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('script')
        <script>
            $wire.on('chatAdded', (event) => {
                alert('tes');
            });
        </script>
    @endpush
</div>
