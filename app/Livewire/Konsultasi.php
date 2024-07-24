<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Konsultasi as KonsultasiModel;
use Livewire\Attributes\On;

class Konsultasi extends Component
{
    public $chat;

    // public function mount()
    // {
    //     $this->klinik = Klinik::all();
    //     if (auth()->user()->role != 'pelanggan') {
    //         $this->konsultasi = KonsultasiModel::where('user_id', '!=', 1)->get();
    //     } else {
    //         $this->konsultasi = KonsultasiModel::all();
    //     }
    // }

    #[On('chatAdded')]
    public function render()
    {
        return view('livewire.konsultasi', [
            'konsultasi' => KonsultasiModel::where('user_id', '!=', 1)->orderBy('id', 'asc')->get(),
        ]);
    }

    public function kirim()
    {
        if (empty($this->chat)) {
            flash('Pesan tidak boleh kosong', 'error');
        } else {


            $kode = rand(100000, 999999);
            $lastKonsultasi = KonsultasiModel::where('status', 'Menunggu')->latest()->first();
            if ($lastKonsultasi) {
                $lastKonsultasi2 = KonsultasiModel::where('kode', $lastKonsultasi->kode)->latest()->first();
            }
            // dd($lastKonsultasi);
            if (!$lastKonsultasi) {
                $ahai = KonsultasiModel::create([
                    'user_id' => auth()->user()->id,
                    'kode' => $kode,
                    'chat' => $this->chat,
                    'status' => 'Menunggu',
                ]);

                // KonsultasiModel::create([
                //     'user_id' => 1,
                //     'kode' => $ahai->kode,
                //     'chat' => 'Silahkan melakukan pembayaran terlebih dahulu',
                //     'status' => 'Menunggu',
                // ]);
            } elseif ($lastKonsultasi->user_id != auth()->user()->id) {
                $kode = $lastKonsultasi->kode;
                KonsultasiModel::create([
                    'user_id' => auth()->user()->id,
                    'kode' => $kode,
                    'chat' => $this->chat,
                    'status' => 'Live',
                ]);
            } elseif ($lastKonsultasi->user_id == auth()->user()->id && $lastKonsultasi2->status == 'Live') {
                $kode = $lastKonsultasi->kode;
                KonsultasiModel::create([
                    'user_id' => auth()->user()->id,
                    'kode' => $kode,
                    'chat' => $this->chat,
                    'status' => 'Live',
                ]);
            }

            $this->chat = null;

            $this->dispatch('chatAdded');
        }
    }
}
