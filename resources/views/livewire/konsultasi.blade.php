<div>
    {{-- @if (auth()->user()->role == 'pelanggan')
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            Jika sudah selesai konsultasi, harap tekan tombol Selesai <button type="button"
                class="btn btn-success ms-auto"><i class="bi bi-check"></i></button> disebelah tombol kirim.
        </div>
    @endif --}}
    {{-- @if (isset($trans) && $trans->status == 'Valid') --}}
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
    {{-- @endif --}}

    <section class="section">
        <div class="row">
            @if (auth()->user()->role == 'pelanggan')
                @if (isset($konsultasi[0]) && $konsultasi[0]->user_id == auth()->user()->id)
                    {{-- @if (isset($trans)) --}}
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
                                <form wire:submit="kirim">
                                    <div class="row card-footer">
                                        <div class="col-12">
                                            <div class="input-group">
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                        placeholder="Tulis pesan disini..." wire:model="chat"
                                                        onkeydown="if (event.key === 'Enter') { event.preventDefault(); this.form.dispatchEvent(new Event('submit', { 'bubbles': true })); }">
                                                    <button type="submit" class="btn btn-primary" type="button"><i
                                                            class="bi bi-send"></i> Kirim</button>
                                                    @php
                                                        if (isset($konsultasi) && $konsultasi[0]) {
                                                            $konsultan = $konsultasi[0]->kode;
                                                        }
                                                    @endphp
                                                    <button class="btn btn-success" type="button"
                                                        wire:click="selesai({{ $konsultan }})"><i
                                                            class="bi bi-check"></i> Selesai</button>
                                                </div>
                                            </div>
                                            {{-- @error('chat')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror --}}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- @endif --}}
                @else
                    <div class="col-12">
                        @if (isset($trans) && $trans->status == 'Valid')
                            <div class="col-12 mt-2 text-center">
                                <button class="btn btn-primary btn-block" wire:click="chatNow">Chat Sekarang</button>
                            </div>
                        @else
                            <div class="alert alert-danger text-center" role="alert">
                                Anda belum menyelesaikan pembayaran
                            </div>
                            <div class="col-12 mt-2 text-center">
                                <a href="{{ url('konsultasi/dokter') }}" class="btn btn-secondary btn-block">Kembali</a>
                            </div>
                        @endif
                    </div>
                @endif
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
                                        <div class="col-12">
                                            <div class="input-group">
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                        placeholder="Tulis pesan disini..." wire:model="chat"
                                                        onkeydown="if (event.key === 'Enter') { event.preventDefault(); this.form.dispatchEvent(new Event('submit', { 'bubbles': true })); }">
                                                    <button type="submit" class="btn btn-primary" type="button"><i
                                                            class="bi bi-send"></i> Kirim</button>
                                                </div>
                                            </div>
                                            {{-- @error('chat')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror --}}
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

            document.addEventListener("livewire:init", function() {
                Livewire.hook('message.processed', (message, component) => {
                    if (message.response?.redirect) {
                        window.location.href = message.response.redirect;
                    }
                });

                if (!$trans) {
                    window.location.href = '/home';
                }
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
