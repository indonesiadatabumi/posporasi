<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use PDF;
use Carbon\Carbon;

class LPembayaranController extends Controller
{
    public function index()
    {
        return view('lpembayaran.index');
    }

    public function data(Request $request)
    {
        // Validasi filter tanggal
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $restoranId = Auth::user()->restoran->id;

        // Query untuk mendapatkan data pembayaran
        $query = Pembayaran::where('id_resto', $restoranId);

        // Filter berdasarkan start_date dan end_date jika ada
        if ($start_date = $request->input('start_date')) {
            $query->whereDate('created_at', '>=', Carbon::parse($start_date)->toDateString());
        }

        if ($end_date = $request->input('end_date')) {
            $query->whereDate('created_at', '<=', Carbon::parse($end_date)->toDateString());
        }

        $pembayaran = $query->get();

        return DataTables::of($pembayaran)
            ->addIndexColumn()
            ->addColumn('tanggal_transaksi', function ($row) {
                return $row->created_at ? $row->created_at->format('d-m-Y') : '-';
            })
            ->addColumn('aksi', function ($row) {
                return '';  
            })
            ->make(true);
    }

    public function cetakPdf(Request $request)
    {
        // Validasi filter tanggal
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
    
        $restoranId = Auth::user()->restoran->id;
    
        // Query untuk filter data berdasarkan tanggal
        $query = Pembayaran::where('id_resto', $restoranId);
    
        if ($start_date) {
            $query->whereDate('created_at', '>=', Carbon::parse($start_date)->toDateString());
        }
        if ($end_date) {
            $query->whereDate('created_at', '<=', Carbon::parse($end_date)->toDateString());
        }
    
        $pembayaran = $query->selectRaw('DATE(created_at) as tanggal_transaksi, 
            nomor_struk, subtotal, pajak, total_pembayaran')
            ->orderBy('tanggal_transaksi', 'asc')
            ->get();
    
        $totalSubtotal = $pembayaran->sum('subtotal');
        $totalPajak = $pembayaran->sum('pajak');
        $totalPembayaran = $pembayaran->sum('total_pembayaran');
    
        $data = [
            'pembayaran' => $pembayaran,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'totalSubtotal' => $totalSubtotal,
            'totalPajak' => $totalPajak,
            'totalPembayaran' => $totalPembayaran,
            'current_date' => Carbon::now()->format('d-m-Y'),
        ];
    
        $pdf = PDF::loadView('lpembayaran.pdf', $data)->setPaper('a4', 'portrait');
    
        return $pdf->download('laporan_pembayaran_' . Carbon::now()->format('d_m_Y') . '.pdf');
    }
}
