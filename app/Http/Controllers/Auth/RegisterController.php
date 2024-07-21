<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Pelanggan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'nomor_telepon' => ['required', 'numeric'],
            'alamat' => ['required', 'string', 'max:255'],
            'scan_ktp' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['nama'],
            'role' => 'pelanggan',
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if (isset($data['scan_ktp']) && $data['scan_ktp']->isValid()) {
            $file = $data['scan_ktp'];
            $filename = time() . rand(100, 999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('ktp'), $filename);
        } else {
            // Jika file tidak valid, set nama file menjadi null atau berikan penanganan error
            $filename = null;
        }

        Pelanggan::create([
            'user_id' => $user->id,
            'no_telp' => $data['nomor_telepon'],
            'alamat' => $data['alamat'],
            'scan_ktp' => $filename,
        ]);


        flash()->preset('terdaftar');
        return $user;
    }
}
