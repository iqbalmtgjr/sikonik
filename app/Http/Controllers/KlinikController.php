<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Klinik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KlinikController extends Controller
{
    /**
     * Display a listing of the clinics.
     */
    public function index()
    {
        $klinik = Klinik::all();
        return view('klinik.index', compact('klinik'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_klinik' => 'required',
            'alamat' => 'required',
            'nomor_telepon' => 'required',
            'deskripsi' => 'required',
        ]);

        if ($validator->fails()) {
            toastr()->error('Ada Kesalahan Saat Penginputan.');
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        Klinik::create([
            'nama_klinik' => $request->nama_klinik,
            'alamat' => $request->alamat,
            'no_telp' => $request->nomor_telepon,
            'deskripsi' => $request->deskripsi,
        ]);

        flash()->preset('tersimpan');
        return redirect()->back();
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'nama_klinik' => 'required',
            'alamat' => 'required',
            'nomor_telepon' => 'required',
            'deskripsi' => 'required',
        ]);

        if ($validator->fails()) {
            toastr()->error('Ada Kesalahan Saat Penginputan.');
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $klinik = Klinik::where('id', $request->id)->first();
        $klinik->update([
            'nama_klinik' => $request->nama_klinik,
            'alamat' => $request->alamat,
            'no_telp' => $request->nomor_telepon,
            'deskripsi' => $request->deskripsi,
        ]);

        flash()->preset('terupdate');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $klinik = Klinik::find($id);
        $klinik->delete();
        flash()->preset('terhapus');
        return redirect()->back();
    }

    public function getdata($id)
    {
        $data = Klinik::find($id);
        $data->dokter;
        return $data;
    }

    public function getdata2($id)
    {
        $data = Dokter::where('klinik_id', $id)->with('user')->get();
        return $data;
    }
}
