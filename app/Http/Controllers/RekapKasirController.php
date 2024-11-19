<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF; // Import PDF Facade

class RekapKasirController extends Controller
{
    public function index()
    {
        return view('rekapkasir.index');
    }

    public function data(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $idUser = Auth::id(); // ID user yang sedang login

        // Mulai query pembayaran berdasarkan id user
        $query = Pembayaran::where('id_user', $idUser);

        // Filter berdasarkan tanggal jika start_date dan end_date tersedia
        if ($request->filled('start_date')) {
            $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($request->filled('end_date')) {
            $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
            $query->whereDate('created_at', '<=', $endDate);
        }

        $pembayaran = $query->get();

        // Data untuk DataTables
        return DataTables::of($pembayaran)
            ->addIndexColumn()
            ->addColumn('tanggal_transaksi', function ($row) {
                return $row->created_at ? $row->created_at->format('d-m-Y') : '-';
            })
            ->addColumn('subtotal', function ($row) {
                return 'Rp. ' . number_format($row->subtotal, 0, ',', '.');
            })
            ->addColumn('pajak', function ($row) {
                return 'Rp. ' . number_format($row->pajak, 0, ',', '.');
            })
            ->addColumn('total_pembayaran', function ($row) {
                return 'Rp. ' . number_format($row->total_pembayaran, 0, ',', '.');
            })
            ->addColumn('aksi', function ($row) {
                return '';  // Placeholder for action column if needed
            })
            ->make(true);
    }

    public function exportPdf(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
    
        $idUser = Auth::id(); // ID user yang sedang login
    
        // Query untuk mengambil data dari Rekap Kasir (pembayaran)
        $query = Pembayaran::where('id_user', $idUser);
    
        // Terapkan filter tanggal jika ada
        if ($start_date) {
            $query->whereDate('created_at', '>=', $start_date);
        }
        if ($end_date) {
            $query->whereDate('created_at', '<=', $end_date);
        }
    
        // Ambil data pembayaran
        $rekapKasir = $query->select('nomor_struk', 'created_at', 'subtotal', 'pajak', 'total_pembayaran')
                             ->get();
    
        // Siapkan data untuk tampilan PDF
        $data = [
            'rekapKasir' => $rekapKasir,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'current_date' => Carbon::now()->format('d-m-Y'),
        ];
    
        // Tentukan nama file sesuai periode atau tanggal cetak
        $filename = 'Rekap_Kasir_' . ($start_date && $end_date ? $start_date . '_to_' . $end_date : '' . Carbon::now()->format('d-m-Y'));
    
        $pdf = PDF::loadView('rekapkasir.pdf', $data)->setPaper('a4', 'portrait');
    
        return $pdf->download($filename . '.pdf');
    }
    
}
