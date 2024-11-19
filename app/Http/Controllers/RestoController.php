<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restoran;
use Illuminate\Support\Facades\Auth;

class RestoController extends Controller
{
    public function index()
    {
        $resto = Auth::user()->restoran;

        return view('resto.index', compact('resto'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_resto' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'nomor_telepon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:255',
        ]);
    
        $resto = Auth::user()->restoran;
    
        $resto->nama_resto = $request->nama_resto;
        $resto->email = $request->email;
        $resto->nomor_telepon = $request->nomor_telepon;
        $resto->alamat = $request->alamat;
        $resto->save();
    
        return redirect()->route('resto.index')->with('success', 'Profil restoran berhasil diperbarui.');
    }
    
}
