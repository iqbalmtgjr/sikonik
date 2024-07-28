<?php

namespace App\Livewire;

use App\Models\Dokter;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Konsultasi as KonsultasiModel;
use App\Models\Transaksi;
use App\Models\User;

class Konsultasi extends Component
{
    public $chat;
    public $dokter_id;
    public $kode = null;
    public $trans;

    #[On('chatAdded')]
    public function mount($id)
    {
        $this->dokter_id = $id;
        $this->trans = Transaksi::where('user_id', auth()->user()->id)->first();

        if (auth()->user()->role == 'pelanggan') {
            if (!$this->trans) {
                flash('Konsultasi berakhir.', 'success');
                return redirect('konsultasi/dokter');
            }
            $klinik = Transaksi::where('user_id', auth()->user()->id)->first();
            $dokter = Dokter::find($this->dokter_id);
            $chat_now = KonsultasiModel::where('dokter_id', $this->dokter_id)->first();
            if ($klinik->klinik_id != $dokter->klinik_id) {
                flash('Transaksi anda berada pada ' . $klinik->klinik->nama_klinik . '', 'warning');
                return redirect('konsultasi/dokter');
            }
            if (isset($chat_now->status) && $chat_now->status == 'Live' && $chat_now->user_id != auth()->user()->id) {
                flash('Konsultasi sedang berlangsung. Mohon tunggu sebentar.', 'warning');
                return redirect('konsultasi/dokter');
            }
        }
    }

    public function render()
    {
        if (auth()->user()->role == 'dokter') {
            $nama_pelanggan = KonsultasiModel::where('dokter_id', $this->dokter_id)->first();
            $konsultasis =  KonsultasiModel::where('dokter_id', auth()->user()->dokter->id)
                ->orderBy('id', 'asc')
                ->get();
            $nama_klinik = Dokter::find(auth()->user()->dokter->id)->klinik->nama_klinik;
            return view('livewire.konsultasi', [
                'konsultasi' => $konsultasis,
                'klinik' => $nama_klinik,
                'pelanggan' => $nama_pelanggan,
            ]);
        } else {
            //  pelanggan  //
            $konsultasis = KonsultasiModel::where('dokter_id', $this->dokter_id)
                ->whereIn('user_id', [auth()->user()->id, Dokter::find($this->dokter_id)->user->id])
                ->orderBy('id', 'asc')
                ->get();

            if (count($konsultasis) <= 1) {
                $konsultasi = KonsultasiModel::where('dokter_id', $this->dokter_id)
                    ->whereIn('user_id', [auth()->user()->id])
                    ->orderBy('id', 'asc')
                    ->get();
            } else {
                $konsultasi = $konsultasis;
            }

            // $transs = $this->trans->klinik->nama_klinik;

            return view('livewire.konsultasi', [
                'konsultasi' => $konsultasi,
                'klinik' => $this->trans->klinik->nama_klinik,
                'dokter' => Dokter::find($this->dokter_id)->user->name,
            ]);
        }
    }

    public function kirim()
    {
        if (isset(auth()->user()->transaksi) && auth()->user()->transaksi->status == 'Menunggu') {
            flash('Silahkan melakukan pembayaran terlebih dahulu', 'error');
            return redirect('/konsultasi');
        } elseif (isset(auth()->user()->transaksi) && auth()->user()->transaksi->status == 'Tidak Valid') {
            flash('Pembayaran anda tidak valid', 'error');
            return redirect('/konsultasi');
        }

        if (empty($this->chat)) {
            flash('Pesan tidak boleh kosong', 'error');
        } else {
            $kode = rand(100000, 999999);
            // if (auth()->user()->role != 'dokter') {
            // $lastKonsultasi = KonsultasiModel::where('user_id', auth()->user()->id)->latest()->first();
            // } else {
            $lastKonsultasi = KonsultasiModel::where('dokter_id', $this->dokter_id)->latest()->first();
            // }
            // if ($lastKonsultasi) {
            //     $lastKonsultasi2 = KonsultasiModel::where('kode', $lastKonsultasi->kode)->latest()->first();
            // }
            // dd($lastKonsultasi);
            if (!$lastKonsultasi) {
                KonsultasiModel::create([
                    'user_id' => auth()->user()->id,
                    'dokter_id' => $this->dokter_id,
                    'kode' => $kode,
                    'chat' => $this->chat,
                    'status' => 'Live',
                ]);
            } else {
                $kode = $lastKonsultasi->kode;
                KonsultasiModel::create([
                    'user_id' => auth()->user()->id,
                    'dokter_id' => $this->dokter_id,
                    'kode' => $lastKonsultasi->kode,
                    'chat' => $this->chat,
                    'status' => 'Live',
                ]);
            }

            $this->chat = null;
        }
    }

    public function selesai($kode)
    {
        $konsul = KonsultasiModel::where('kode', $kode)->first();
        $hapus_trans = Transaksi::where('user_id', $konsul->user_id)->first();
        if ($hapus_trans->bukti_bayar) {
            $path = public_path('bukti/' . $hapus_trans->bukti_bayar);
            if (file_exists($path)) {
                @unlink($path);
            }
        }
        $hapus_trans->delete();
        KonsultasiModel::whereIn('kode', [$kode])->delete();

        flash()->preset('selesai');
        return redirect('/home');

        $this->dispatch('chatAdded', $this->dokter_id);
    }
}
