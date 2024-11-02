<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Pembayaran;
use App\Models\Supplier;
use App\Models\Pengeluaran;
use App\Models\Pemasukan;
use App\Models\Toko;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class TokoController extends Controller
{
    public function index()
    {
        // Mengembalikan view untuk daftar toko
        return view('toko.index');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
        ]);

        Toko::create([
            'nama_toko' => $request->nama_toko,
            'alamat' => $request->alamat,
            'id_user' => Auth::id(), // Mengambil ID pengguna yang sedang login
        ]);

        return redirect()->route('toko.index')->with('success', 'Toko berhasil ditambahkan');
    }

    public function dashboard($id)
    {
        // Cari toko berdasarkan id
        $toko = Toko::findOrFail($id);
    
        // Simpan id toko yang dipilih ke dalam session
        session(['id_toko' => $toko->id]);
    
        // Mengirim data toko ke view dashboard
        return view('toko.dashboard', compact('toko'));
    }

    public function data()
    {
        $toko = Toko::with('user')->select('id', 'nama_toko', 'alamat', 'id_user')->get();

        return DataTables::of($toko)
            ->addIndexColumn()
            ->addColumn('aksi', function ($toko) {
                return '
                <div class="btn-group">
                    <button onclick="editForm(`' . route('toko.update', $toko->id) . '`)" class="btn btn-xs btn-info btn-flat">
                        <i class="fa fa-pencil"></i>
                    </button>
                    <button onclick="deleteData(`' . route('toko.destroy', $toko->id) . '`)" class="btn btn-xs btn-danger btn-flat">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function edit($id)
    {
        // Mengambil data toko untuk diedit
        $toko = Toko::find($id);
        return response()->json($toko);
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
        ]);

        $toko = Toko::find($id);
        $toko->update([
            'nama_toko' => $request->nama_toko,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('toko.index')->with('success', 'Toko berhasil diperbarui');
    }

    public function destroy($id)
    {
        $toko = Toko::find($id);
        $toko->delete();

        return response()->json(['success' => 'Toko berhasil dihapus']);
    }
}
