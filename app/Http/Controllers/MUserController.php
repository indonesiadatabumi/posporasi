<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MUserController extends Controller
{
    public function index()
    {
        $users = User::where('id_resto', Auth::user()->restoran->id)
                    ->whereIn('role', ['kasir', 'kitchen']) // Memfilter berdasarkan role
                    ->get();
        
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create', ['roles' => ['kasir', 'kitchen']]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_identitas' => 'required|string|max:255|unique:users,nomor_identitas',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:kasir,kitchen',
            'alamat' => 'nullable|string',
            'nomor_telepon' => 'nullable|string|max:20',
        ]);

        $id_resto = Auth::user()->id_resto;

        User::create([
            'nama' => $request->nama,
            'id_resto' => $id_resto,
            'nomor_identitas' => $request->nomor_identitas,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'alamat' => $request->alamat,
            'nomor_telepon' => $request->nomor_telepon,
        ]);

        return redirect()->route('users.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
{
    // Validasi input
    $request->validate([
        'nama' => 'required|string|max:255',
        'nomor_identitas' => 'required|string|max:255|unique:users,nomor_identitas,' . $id,
        'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        'role' => 'required|in:kasir,kitchen',
        'alamat' => 'nullable|string',
        'nomor_telepon' => 'nullable|string|max:20',
        'password' => 'nullable|string|min:8|confirmed', // Membuat password menjadi opsional
    ]);

    $user = User::findOrFail($id);

    $user->nama = $request->nama;
    $user->nomor_identitas = $request->nomor_identitas;
    $user->email = $request->email;
    $user->role = $request->role;
    $user->alamat = $request->alamat;
    $user->nomor_telepon = $request->nomor_telepon;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui.');
}


public function destroy($id)
{
    $user = User::findOrFail($id);
    
    // Menghapus pengguna
    $user->delete();

    return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
}

}
