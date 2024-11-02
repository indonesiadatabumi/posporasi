<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class LPembayaranController extends Controller
{
    public function index()
    {
        return view('lpembayaran.index');
    }

    public function data()
    {
        // Ambil pembayaran yang terkait dengan restoran pengguna yang sedang login
        $pembayaran = Pembayaran::where('id_resto', Auth::user()->restoran->id)->get();

        return DataTables::of($pembayaran)
            ->addIndexColumn()
            ->addColumn('tanggal_transaksi', function ($row) {
                return $row->created_at ? $row->created_at->format('d-m-Y') : '-'; // Tampilkan hanya tanggal
            })
            ->addColumn('aksi', function ($row) {
                return ''; // Hilangkan aksi edit dan delete
            })
            ->make(true);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'metode_pembayaran' => 'required|string|max:50',
            'subtotal' => 'required|numeric',
            'pajak' => 'required|numeric',
            'total_pembayaran' => 'required|numeric',
            'nomor_struk' => 'nullable|string|max:50',
        ]);

        // Tambahkan id_resto dari restoran pengguna yang sedang login
        $validatedData['id_resto'] = Auth::user()->restoran->id;

        Pembayaran::create($validatedData);

        return response()->json(['success' => 'Pembayaran berhasil ditambahkan.']);
    }
}
