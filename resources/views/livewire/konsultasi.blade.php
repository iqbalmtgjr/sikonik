<div>
    <div class="container">
        <div class="row text-center">
            <div class="col">
                <h2 class="text-primary fw-bold">Konsultasi di {{ $klinik }}</h2>
                @if (auth()->user()->role == 'pelanggan')
                    <p class="text-muted">Dokter: <span class="fw-bold">{{ $dokter }}</span></p>
                @else
                    <p class="text-muted">Pelanggan: <span
                            class="fw-bold">{{ isset($pelanggan) ? $pelanggan->user->name : '' }}</span></p>
                @endif
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row">
            @if (auth()->user()->role == 'pelanggan')
                <div class="col-12">
                    <div class="card">
                        <div class="card-body d-flex flex-column">
                            <div class="row flex-grow-1">
                                <div class="col-12 chat-scrollable" style="height: calc(80vh - 100px)">
                                    <div wire:poll>
                                        @foreach ($konsultasi as $item)
                                            @php
                                                $now = new DateTime();
                                                $ago = new DateTime($item->created_at);
                                                $diff = $now->diff($ago);
                                                $formattedTime = $ago->format('H:i');
                                            @endphp
                                            @if ($item->user_id == auth()->user()->id)
                                                <div class="d-flex justify-content-end">
                                                    <div class="chat-bubble chat-bubble-sender">
                                                        {{ $item->chat }} <br>
                                                        <div class="text-end">
                                                            <span class="text-small text-muted"
                                                                style="font-size: 11px;">
                                                                {{ $formattedTime }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="d-flex justify-content-start">
                                                    <div class="chat-bubble chat-bubble-receiver">
                                                        {{ $item->chat }} <br>
                                                        <span class="text-small text-muted" style="font-size: 11px">
                                                            {{ $formattedTime }}
                                                        </span>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <form wire:submit.prevent="kirim">
                                <div class="row card-footer">
                                    <div class="col-11">
                                        <input type="text" class="form-control chat-input"
                                            placeholder="Tulis pesan disini..." wire:model.debounce.500ms="chat"
                                            onkeydown="if (event.key === 'Enter') { event.preventDefault(); this.form.dispatchEvent(new Event('submit', { 'bubbles': true })); }">
                                    </div>
                                    <div class="col-1 d-flex align-items-center">
                                        <button type="submit" class="btn btn-primary ms-auto mr-2"><i
                                                class="bi bi-send"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                @if (isset($konsultasi[0]) && $konsultasi[0]->dokter_id == auth()->user()->dokter->id)
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body d-flex flex-column">
                                <div class="row flex-grow-1">
                                    <div class="col-12 chat-scrollable" style="height: calc(110vh - 140px)">
                                        <div wire:poll>
                                            @foreach ($konsultasi as $item)
                                                @php
                                                    $now = new DateTime();
                                                    $ago = new DateTime($item->created_at);
                                                    $diff = $now->diff($ago);
                                                    $formattedTime = $ago->format('H:i');
                                                @endphp
                                                @if ($item->user_id == auth()->user()->id)
                                                    <div class="d-flex justify-content-end">
                                                        <div class="chat-bubble chat-bubble-sender">
                                                            {{ $item->chat }} <br>
                                                            <div class="text-end">
                                                                <span class="text-small text-muted"
                                                                    style="font-size: 11px;">
                                                                    {{ $formattedTime }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="d-flex justify-content-start">
                                                        <div class="chat-bubble chat-bubble-receiver">
                                                            {{ $item->chat }} <br>
                                                            <span class="text-small text-muted" style="font-size: 11px">
                                                                {{ $formattedTime }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <form wire:submit.prevent="kirim">
                                    <div class="row card-footer">
                                        <div class="col-11">
                                            <input type="text" class="form-control chat-input"
                                                placeholder="Tulis pesan disini..." wire:model.debounce.500ms="chat"
                                                onkeydown="if (event.key === 'Enter') { event.preventDefault(); this.form.dispatchEvent(new Event('submit', { 'bubbles': true })); }">
                                        </div>
                                        <div class="col-1 d-flex align-items-center">
                                            <button type="submit" class="btn btn-primary ms-auto mr-2"><i
                                                    class="bi bi-send"></i></button>
                                            @php
                                                if (isset($konsultasi) && $konsultasi[0]) {
                                                    $konsultasis = $konsultasi[0]->kode;
                                                }
                                            @endphp
                                            @if (auth()->user()->role == 'dokter')
                                                <button type="button" class="btn btn-success ms-auto"
                                                    wire:click="selesai({{ $konsultasis }})"><i
                                                        class="bi bi-check"></i></button>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-12">
                        <div class="alert alert-danger" role="alert">
                            Tidak ada chat yang masuk
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </section>

    @push('style')
        <style>
            .chat-scrollable {
                max-height: calc(100vh - 200px);
                overflow-y: auto;
                padding-top: 20px;
            }

            .chat-input {
                resize: none;
            }

            .chat-bubble {
                border-radius: 15px;
                padding: 10px;
                margin-bottom: 10px;
            }

            .chat-bubble-sender {
                background-color: #007bff;
                color: #fff;
                margin-left: 50%;
            }

            .chat-bubble-receiver {
                background-color: #6c757d;
                color: #fff;
                margin-right: 50%;
            }
        </style>
    @endpush
    @push('script')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                scrollToBottom();
            });

            document.addEventListener("livewire:load", function() {
                Livewire.hook('chatAdded', (message, component) => {
                    scrollToBottom();
                });
            });

            function scrollToBottom() {
                var chatScrollable = document.querySelector(".chat-scrollable");
                if (chatScrollable) {
                    chatScrollable.scrollTop = chatScrollable.scrollHeight;
                }
            }
        </script>
    @endpush
</div>
