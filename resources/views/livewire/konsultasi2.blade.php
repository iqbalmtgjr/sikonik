<div>
    <section class="section">
        <div class="card" style="height: calc(100vh - 140px);">
            <div class="card-body d-flex flex-column">
                <div class="row">
                    <div class="col-12 mt-3">
                        <h5 class="text-center">Chat Konsultasi</h5>
                        <hr>
                    </div>
                </div>
                <div class="row flex-grow-1">
                    <div class="col-12 chat-scrollable">
                        <div class="mt-4" wire:poll>
                            @foreach ($konsultasi as $item)
                                @if ($item->user_id == auth()->user()->id)
                                    <div class="d-flex justify-content-end">
                                        <div class="chat-bubble chat-bubble-sender">
                                            {{ $item->chat }}
                                        </div>
                                    </div>
                                @else
                                    <div class="d-flex justify-content-start">
                                        <div class="chat-bubble chat-bubble-receiver">
                                            {{ $item->chat }}
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <form wire:submit.prevent="kirim" class="mt-3">
                    <div class="row">
                        <div class="col-11">
                            <input type="text" class="form-control chat-input" placeholder="Tulis pesan disini..."
                                wire:model.debounce.500ms="chat"
                                onkeydown="if (event.key === 'Enter') { event.preventDefault(); this.form.dispatchEvent(new Event('submit', { 'bubbles': true })); }">
                        </div>
                        <div class="col-1 d-flex align-items-center">
                            {{-- @if (Agent::isMobile())
                                <button type="submit" class="btn btn-primary ms-auto">
                                    <i class="bi bi-send"></i>
                                </button>
                            @else
                                <button type="submit" class="btn btn-primary ms-auto">Kirim</button>
                            @endif --}}
                            <button type="submit" class="btn btn-primary ms-auto">Kirim</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    @push('style')
        <style>
            .chat-scrollable {
                max-height: calc(100vh - 200px);
                overflow-y: auto;
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
            }

            .chat-bubble-receiver {
                background-color: #6c757d;
                color: #fff;
            }
        </style>
    @endpush
</div>
