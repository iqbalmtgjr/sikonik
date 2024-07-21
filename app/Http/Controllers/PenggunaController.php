<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dokter;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('pengguna.index', compact('users'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'alamat' => 'required',
            'nomor_telepon' => 'required',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            toastr()->error('Ada Kesalahan Saat Penginputan.');
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,
        ]);

        if ($request->role == 'dokter') {
            Dokter::create([
                'users_id' => $user->id,
                'no_telp' => $request->nomor_telepon,
                'alamat' => $request->alamat,
            ]);
        }

        flash()->preset('tersimpan');
        return redirect()->back();
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required',
            'nomor_telepon' => 'required',
            'alamat' => 'required',
        ]);

        if ($validator->fails()) {
            toastr()->error('Ada Kesalahan Saat Penginputan.');
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::where('email', $request->email)->first();
        $user->update([
            'name' => $request->nama,
            'email' => $request->email,
        ]);

        if ($user->role == 'dokter') {
            Dokter::where('user_id', $user->id)->update([
                'no_telp' => $request->nomor_telepon,
                'alamat' => $request->alamat,
            ]);
        } else {
            Pelanggan::where('user_id', $user->id)->update([
                'no_telp' => $request->nomor_telepon,
                'alamat' => $request->alamat,
            ]);
        }

        flash()->preset('terupdate');
        return redirect()->back();
    }

    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        flash()->preset('terhapus');
        return redirect()->back();
    }

    public function getdata($id)
    {
        $data = User::find($id);
        $data->dokter;
        $data->pelanggan;
        return $data;
    }
}
