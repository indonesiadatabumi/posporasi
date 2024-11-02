<?php

namespace App\Http\Controllers;

use App\Models\PembelianDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB; 
use Carbon\Carbon; // Pastikan ini diimport jika belum ada
use Illuminate\Support\Facades\Auth; // Import Auth

class LPenjualanController extends Controller
{
    public function index()
    {
        return view('lpenjualan.index'); 
    }

    public function data()
    {
        $restoId = Auth::user()->restoran->id; // Mengakses id_restoran pengguna

        $pembelianDetails = PembelianDetail::with('produk')
            ->whereHas('pembelian', function ($query) use ($restoId) {
                $query->where('id_resto', $restoId); 
            })
            ->select('id_produk', DB::raw('DATE(created_at) as tanggal'), DB::raw('SUM(jumlah) as total_terjual'))
            ->groupBy('id_produk', 'tanggal')
            ->orderBy('tanggal', 'asc')  
            ->orderBy('id_produk', 'asc')  
            ->get();

        $data = $pembelianDetails->map(function ($row) {
            $hargaJual = $row->produk->harga_jual ?? 0; 
            $pendapatan = $hargaJual * $row->total_terjual;  

            return [
                'tanggal_transaksi' => $row->tanggal ? Carbon::parse($row->tanggal)->format('d-m-Y') : '-', // Tampilkan tanggal
                'nama_produk' => $row->produk->nama_produk ?? 'N/A',  
                'kode_produk' => $row->produk->kode_produk ?? 'N/A',  
                'terjual' => $row->total_terjual,  
                'harga_jual' => format_uang($hargaJual), // Format harga jual
                'pendapatan' => format_uang($pendapatan), // Format pendapatan
            ];
        });

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function () {
                return ''; // Hilangkan aksi edit dan delete
            })
            ->make(true);
    }
}
