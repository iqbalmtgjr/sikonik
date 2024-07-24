<!-- resources/views/livewire/chat.blade.php -->

<div>
    <div class="pagetitle">
        <h1>Konsultasi</h1>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center mt-3">Chat Konsultasi</h5>
                        <hr>

                        <div class="chat-scrollable h-100" wire:poll>
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
                        <form wire:submit="kirim" onsubmit="event.target.chat.blur()" class="card-footer d-flex">
                            <div class="col-11">
                                <input type="text" class="form-control chat-input"
                                    placeholder="Tulis pesan disini..." wire:model.debounce.500ms="chat"
                                    onkeydown="if (event.key === 'Enter') this.form.kirim()">
                            </div>
                            <div class="col-1 d-flex align-items-center">
                                <button type="submit" class="btn btn-primary ms-auto">Kirim</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>


    <script>
        function updateChatScroll() {
            const chatScrollable = document.querySelector('.chat-scrollable');
            chatScrollable.scrollTop = chatScrollable.scrollHeight;
        }

        window.addEventListener('livewire:load', updateChatScroll);

        Livewire.on('chatAdded', updateChatScroll);
    </script>
</div>
