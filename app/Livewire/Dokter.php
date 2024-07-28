<?php

namespace App\Livewire;

use App\Models\Dokter as DokterModel;
use Livewire\Component;
use App\Models\Transaksi;

class Dokter extends Component
{
    public function render()
    {
        return view('livewire.dokter', [
            'dokter' => DokterModel::all(),
        ]);
    }

    public function selectDokter($klinik_id, $id_dokter)
    {
        $transaksi = Transaksi::where('user_id', auth()->user()->id)->first();
        if (auth()->user()->role == 'pelanggan' && $transaksi == null) {
            return redirect('/transaksi/tagihan/' . $klinik_id);
        } else if (auth()->user()->role == 'pelanggan' && $transaksi != null && $transaksi->status == 'Menunggu') {
            return redirect('/transaksi/tagihan/' . $klinik_id);
        } else if (auth()->user()->role == 'pelanggan' && $transaksi != null && $transaksi->status == 'Tidak Valid') {
            flash('Pembayaran anda tidak valid', 'error');
            return redirect('/transaksi/tagihan/' . $klinik_id);
        } else {
            return redirect('/konsultasi' . '/' . $id_dokter);
        }
    }
}
