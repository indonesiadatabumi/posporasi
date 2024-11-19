<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');  
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'nullable|string|max:255',
            // 'nama_resto' => 'nullable|string|max:255',
            'nomor_telepon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $user->nama = $request->nama;
        // $user->nama_resto = $request->nama_resto;
        $user->nomor_telepon = $request->nomor_telepon;
        $user->alamat = $request->alamat;
        $user->save();

        return redirect()->route('profile.index')->with('success', 'Informasi profil berhasil diperbarui.');
    }
}
