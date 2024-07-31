<?php

namespace App\Http\Controllers;

use App\Models\Klinik;
use App\Models\Janjitemu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JanjitemuController extends Controller
{
    public function index()
    {
        if (auth()->user()->role == 'admin') {
            $janji = Janjitemu::all();
        } else if (auth()->user()->role == 'pelanggan') {
            $janji = Janjitemu::where('user_id', auth()->user()->id)->get();
        } else {
            $janji = Janjitemu::where('klinik_id', auth()->user()->adminklinik->klinik_id)->get();
        }
        $klinik = Klinik::all();
        ///  dd($janji);
        return view('janjitemu.index', compact('janji', 'klinik'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_klinik' => 'required',
            'jenis_hewan' => 'required',
            'keluhan_hewan' => 'required',
            'waktu' => 'required',
        ]);

        if ($validator->fails()) {
            toastr()->error('Ada Kesalahan Saat Penginputan.');
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        Janjitemu::create([
            'user_id' => auth()->user()->id,
            'klinik_id' => $request->nama_klinik,
            'jenis_hewan' => $request->jenis_hewan,
            'keluhan_hewan' => $request->keluhan_hewan,
            'waktu' => $request->waktu,
            'catatan' => $request->catatan,
            'status' => 'Menunggu',
        ]);

        flash()->preset('tersimpan');
        return redirect()->back();
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_klinik' => 'required',
            'jenis_hewan' => 'required',
            'keluhan_hewan' => 'required',
            'waktu' => 'required',
        ]);

        if ($validator->fails()) {
            toastr()->error('Ada Kesalahan Saat Penginputan.');
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $janji = Janjitemu::find($request->id);

        if (auth()->user()->role == 'pelanggan' && $request->waktu != $janji->waktu) {
            $janji->update([
                'user_id' => auth()->user()->id,
                'klinik_id' => $request->nama_klinik,
                'jenis_hewan' => $request->jenis_hewan,
                'keluhan_hewan' => $request->keluhan_hewan,
                'waktu' => $request->waktu,
                'status' => 'Menunggu',
            ]);
        } else {
            $janji->update([
                // 'user_id' => auth()->user()->id,
                'klinik_id' => $request->nama_klinik,
                'jenis_hewan' => $request->jenis_hewan,
                'keluhan_hewan' => $request->keluhan_hewan,
                'waktu' => $request->waktu,
                'status' => $request->status,
            ]);
        }

        flash()->preset('terupdate');
        return redirect()->back();
    }

    public function updatecatatan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'catatan' => 'required',
        ]);

        if ($validator->fails()) {
            toastr()->error('Ada Kesalahan Saat Penginputan.');
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $janji = Janjitemu::find($request->idd);
        $janji->update([
            'catatan' => $request->catatan,
        ]);

        flash()->preset('terupdate');
        return redirect()->back();
    }

    public function destroy(string $id)
    {
        $janji = Janjitemu::find($id);
        $janji->delete();

        flash()->preset('terhapus');
        return redirect()->back();
    }

    public function getdata(string $id)
    {
        $data = Janjitemu::find($id);
        $data->user;
        $data->klinik;
        return $data;
    }
    public function getdata2(string $id)
    {
        $data = Janjitemu::find($id);
        return $data;
    }
}
