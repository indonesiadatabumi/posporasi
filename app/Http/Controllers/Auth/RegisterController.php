<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;  
use App\Models\Restoran; // Pastikan Anda menggunakan model Restoran
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Menampilkan halaman registrasi.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register'); 
    }

    /**
     * Menghandle proses registrasi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $restoran = Restoran::create([
            'nama_resto' => $request->nama_resto,
            'nomor_identitas' => $request->nomor_identitas,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'nomor_telepon' => $request->nomor_telepon,
        ]);

        $user = $this->create($request->all(), $restoran->id);

        auth()->login($user);

        return redirect()->intended('/dashboard');  
    }

    /**
     * Validasi input pengguna.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nama' => 'required|string|max:255',
            'nama_resto' => 'required|string|max:255',
            'nomor_identitas' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'alamat' => 'nullable|string|max:255', 
            'nomor_telepon' => 'nullable|string|max:15',  
        ]);
    }

    /**
     * Buat pengguna baru.
     *
     * @param  array  $data
     * @param  int  $restoranId
     * @return \App\Models\User
     */
    protected function create(array $data, $restoranId)
    {
        return User::create([
            'nama' => $data['nama'],
            'id_resto' => $restoranId, 
            'nomor_identitas' => $data['nomor_identitas'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'owner',  
            'alamat' => $data['alamat'] ?? null,  
            'nomor_telepon' => $data['nomor_telepon'] ?? null,  
        ]);
    }
}
