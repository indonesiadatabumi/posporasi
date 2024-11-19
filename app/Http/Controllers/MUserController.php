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
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:kasir,kitchen',
            'alamat' => 'nullable|string',
            'nomor_telepon' => 'nullable|string|max:20',
        ]);

        $id_resto = Auth::user()->id_resto;

        $user = User::create([
            'nama' => $request->nama,
            'id_resto' => $id_resto,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'alamat' => $request->alamat,
            'nomor_telepon' => $request->nomor_telepon,
        ]);

        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        'role' => 'required|in:kasir,kitchen',
        'alamat' => 'nullable|string',
        'nomor_telepon' => 'nullable|string|max:20',
        'password' => 'nullable|string|min:8',  
    ]);

    $user = User::findOrFail($id);
    $user->removeRole($user->role);
    $user->nama = $request->nama;
    $user->email = $request->email;
    $user->role = $request->role;
    $user->alamat = $request->alamat;
    $user->nomor_telepon = $request->nomor_telepon;

    $user->assignRole($request->role);

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui.');
}


public function destroy($id)
{
    $user = User::findOrFail($id);
    
    $user->delete();

    return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
}

}
