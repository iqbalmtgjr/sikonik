<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    public function index()
    {
        $data = Transaksi::all();
        return view('transaksi.index', compact('data'));
    }

    public function tagihan()
    {
        return view('transaksi.tagihan');
    }

    public function store(Request $request)
    {
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

        $data = Transaksi::where('user_id', auth()->user()->id)->where('status', 'Menunggu')->first();
        // hapus foto lama
        if ($data->bukti_bayar) {
            $old_file = public_path('bukti/') . $data->bukti_bayar;
            if (file_exists($old_file)) {
                unlink($old_file);
            }

            $data->update([
                'bukti_bayar' => $filename,
            ]);

            flash()->preset('terupdate');
            return redirect()->back();
        } else {
            Transaksi::create([
                'user_id' => auth()->user()->id,
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

    public function getdata($id)
    {
        $data = Transaksi::find($id);
        return $data;
    }
}
