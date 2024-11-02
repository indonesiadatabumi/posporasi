<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class PemasukanController extends Controller
{
    public function index()
    {
        return view('pemasukan.index'); // Menampilkan halaman index laporan pemasukan
    }

    public function data(Request $request)
    {
        // Validasi rentang tanggal
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Ambil ID restoran dari pengguna yang sedang login
        $restoranId = Auth::user()->restoran->id; // Mengakses ID restoran

        // Ambil data pembayaran berdasarkan rentang tanggal dan ID restoran
        $query = Pembayaran::query()
            ->where('id_resto', $restoranId);

        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            // Menambahkan satu hari pada end_date agar mencakup seluruh hari
            $query->whereBetween('created_at', [$startDate, date('Y-m-d', strtotime($endDate . ' +1 day'))]);
        }

        // Mengelompokkan berdasarkan tanggal dan menjumlahkan subtotal, pajak, dan total_pemasukan
        $pembayaran = $query->selectRaw('DATE(created_at) as tanggal_transaksi, 
            SUM(subtotal) as total_subtotal, 
            SUM(pajak) as total_pajak, 
            SUM(total_pembayaran) as total_pemasukan')
            ->groupBy('tanggal_transaksi')
            ->get();

        // Mengembalikan DataTables
        return DataTables::of($pembayaran)
            ->addIndexColumn()
            ->addColumn('tanggal_transaksi', function ($row) {
                return $row->tanggal_transaksi ? \Carbon\Carbon::parse($row->tanggal_transaksi)->format('d-m-Y') : '-'; // Format tanggal
            })
            ->addColumn('subtotal', function ($row) {
                return 'Rp. ' . number_format($row->total_subtotal, 0, ',', '.'); // Format subtotal tanpa ,00
            })
            ->addColumn('pajak', function ($row) {
                return 'Rp. ' . number_format($row->total_pajak, 0, ',', '.'); // Format pajak tanpa ,00
            })
            ->addColumn('total_pemasukan', function ($row) {
                return 'Rp. ' . number_format($row->total_pemasukan, 0, ',', '.'); // Format total pemasukan tanpa ,00
            })
            ->addColumn('aksi', function ($row) {
                return ''; 
            })
            ->make(true);
    }
}
