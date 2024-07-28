<?php

namespace App\Http\Controllers;

use App\Models\Klinik;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    public function index()
    {
        $data = Transaksi::where('klinik_id', auth()->user()->adminklinik->klinik_id)->get();
        return view('transaksi.index', compact('data'));
    }

    public function tagihan($klinik_id)
    {
        $klinik = Klinik::find($klinik_id);
        $transaksi = Transaksi::where('user_id', auth()->user()->id)->where('klinik_id', $klinik_id)->first();
        $klinik_skrng = Transaksi::where('user_id', auth()->user()->id)->first();
        // dd($transaksi);
        if ($klinik_skrng == null) {
            return view('transaksi.tagihan', compact('klinik'));
        } else if ($klinik_skrng->klinik_id != $klinik_id) {
            flash('Transaksi anda berada pada klinik yang lain', 'error');
            return redirect()->back();
        }

        return view('transaksi.tagihan', compact('klinik'));
    }

    public function store(Request $request)
    {
        // dd($request->klinik_id);
        $validator = Validator::make($request->all(), [
            'bukti_bayar' => 'required',
        ]);

        if ($validator->fails()) {
            toastr()->error('Ada Kesalahan Saat Penginputan.');
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $file = $request->file('bukti_bayar');
        $filename = time() . rand(100, 999) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('bukti'), $filename);

        $data = Transaksi::where('user_id', auth()->user()->id)->first();
        // hapus foto lama
        if (isset($data->bukti_bayar) && $data->status == 'Menunggu') {
            $old_file = public_path('bukti/') . $data->bukti_bayar;
            if (file_exists($old_file)) {
                unlink($old_file);
            }

            $data->update([
                'bukti_bayar' => $filename,
            ]);

            flash()->preset('terupdate');
            return redirect()->back();
        } elseif (isset($data->bukti_bayar) && $data->status == 'Tidak Valid') {
            $old_file = public_path('bukti/') . $data->bukti_bayar;
            if (file_exists($old_file)) {
                unlink($old_file);
            }

            $data->update([
                'bukti_bayar' => $filename,
                'status' => 'Menunggu',
            ]);

            flash()->preset('terupdate');
            return redirect()->back();
        } else {
            Transaksi::create([
                'user_id' => auth()->user()->id,
                'klinik_id' => $request->klinik_id,
                'bukti_bayar' => $filename,
                'harga' => 20000,
                'status' => 'Menunggu',
            ]);

            flash()->preset('tersimpan');
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'validasi' => 'required',
        ]);

        if ($validator->fails()) {
            toastr()->error('Ada Kesalahan Saat Penginputan.');
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = Transaksi::find($request->id);
        $data->update([
            'status' => $request->validasi,
        ]);

        flash()->preset('terupdate');
        return redirect()->back();
    }

    public function destroy(string $id)
    {
        Transaksi::find($id)->delete();

        flash()->preset('terhapus');
        return redirect()->back();
    }

    public function getdata($id)
    {
        $data = Transaksi::find($id);
        return $data;
    }
}
