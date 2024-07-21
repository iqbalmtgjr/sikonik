<?php

namespace App\Http\Controllers;

use App\Models\Adminklinik;
use App\Models\User;
use App\Models\Dokter;
use App\Models\Klinik;
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
        // dd(auth()->user()->adminklinik->klinik_id);
        if (auth()->user()->role == 'admin_klinik') {
            $dokter = Dokter::where('klinik_id', auth()->user()->adminklinik->klinik_id)
                ->get();
            $id = $dokter->pluck('user_id');
            $users = User::whereIn('id', $id)
                ->get();
        } else {
            $users = User::where('role', '!=', 'admin')->get();
        }
        $klinik = Klinik::all();
        return view('pengguna.index', compact('users', 'klinik'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role == 'admin') {
            $validator = Validator::make($request->all(), [
                'nama' => 'required',
                'email' => 'required|unique:users',
                'password' => 'required',
                'alamat' => 'required',
                'nomor_telepon' => 'required',
                'role' => 'required',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'nama' => 'required',
                'email' => 'required|unique:users',
                'password' => 'required',
                'alamat' => 'required',
                'nomor_telepon' => 'required',
            ]);
        }


        if ($validator->fails()) {
            toastr()->error('Ada Kesalahan Saat Penginputan.');
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }



        if (auth()->user()->role == 'admin') {
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => $request->password,
                'role' => $request->role,
            ]);

            if ($request->role == 'dokter') {
                Dokter::create([
                    'user_id' => $user->id,
                    'no_telp' => $request->nomor_telepon,
                    'alamat' => $request->alamat,
                ]);
            } elseif ($request->role == 'admin_klinik') {
                Adminklinik::create([
                    'user_id' => $user->id,
                    'no_telp' => $request->nomor_telepon,
                    'alamat' => $request->alamat,
                ]);
            }
        } else {
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => $request->password,
                'role' => 'dokter',
            ]);
            Dokter::create([
                'user_id' => $user->id,
                'klinik_id' => auth()->user()->adminklinik->klinik_id,
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
        } elseif ($user->role == 'admin_klinik') {
            Adminklinik::where('user_id', $user->id)->update([
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

    public function updateKlinik(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'klinik' => 'required',
        ]);

        if ($validator->fails()) {
            toastr()->error('Ada Kesalahan Saat Penginputan.');
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::where('email', $request->email2)->first();
        if ($user->role == 'dokter') {
            Dokter::where('user_id', $user->id)->update([
                'klinik_id' => $request->klinik,
            ]);
        } elseif ($user->role == 'admin_klinik') {
            Adminklinik::where('user_id', $user->id)->update([
                'klinik_id' => $request->klinik,
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
        $data->adminklinik;
        return $data;
    }
}
