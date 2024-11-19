<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use PDF;
use Carbon\Carbon;
class PemasukanController extends Controller
{
    public function index()
    {
        return view('pemasukan.index'); 
    }

public function exportPdf(Request $request)
{
    $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');

    $query = Pembayaran::query();

    if ($start_date) {
        $query->whereDate('created_at', '>=', $start_date);
    }
    if ($end_date) {
        $query->whereDate('created_at', '<=', $end_date);
    }

    $pembayaran = $query->selectRaw('DATE(created_at) as tanggal_transaksi, 
        SUM(subtotal) as total_subtotal, 
        SUM(pajak) as total_pajak, 
        SUM(total_pembayaran) as total_pemasukan')
        ->groupBy('tanggal_transaksi')
        ->get();

    $grandTotalSubtotal = $pembayaran->sum('total_subtotal');
    $grandTotalPajak = $pembayaran->sum('total_pajak');
    $grandTotalPemasukan = $pembayaran->sum('total_pemasukan');

    $data = [
        'pembayaran' => $pembayaran,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'current_date' => Carbon::now()->format('d-m-Y'),
        'grandTotalSubtotal' => $grandTotalSubtotal,
        'grandTotalPajak' => $grandTotalPajak,
        'grandTotalPemasukan' => $grandTotalPemasukan,
    ];

    $pdf = PDF::loadView('pemasukan.pemasukan_pdf', $data)->setPaper('a4', 'landscape');

    return $pdf->download('laporan_pemasukan_' . Carbon::now()->format('d_m_Y') . '.pdf');
}

public function data(Request $request)
{
    $request->validate([
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
    ]);

    $restoranId = Auth::user()->restoran->id;  

    $query = Pembayaran::query()
        ->where('id_resto', $restoranId);

    if ($request->filled('start_date')) {
        $startDate = $request->input('start_date');
        $query->where('created_at', '>=', $startDate);
    }

    if ($request->filled('end_date')) {
        $endDate = $request->input('end_date');
        $query->whereBetween('created_at', [$startDate, Carbon::parse($endDate)->addDay()->format('Y-m-d')]);

    }

    $pembayaran = $query->selectRaw('DATE(created_at) as tanggal_transaksi, 
        SUM(subtotal) as total_subtotal, 
        SUM(pajak) as total_pajak, 
        SUM(total_pembayaran) as total_pemasukan')
        ->groupBy('tanggal_transaksi')
        ->get();

    return DataTables::of($pembayaran)
        ->addIndexColumn()
        ->addColumn('tanggal_transaksi', function ($row) {
            return $row->tanggal_transaksi ? \Carbon\Carbon::parse($row->tanggal_transaksi)->format('d-m-Y') : '-'; // Format tanggal
        })
        ->addColumn('subtotal', function ($row) {
            return 'Rp. ' . number_format($row->total_subtotal, 0, ',', '.'); 
        })
        ->addColumn('pajak', function ($row) {
            return 'Rp. ' . number_format($row->total_pajak, 0, ',', '.');  
        })
        ->addColumn('total_pemasukan', function ($row) {
            return 'Rp. ' . number_format($row->total_pemasukan, 0, ',', '.');  
        })
        ->make(true);
}

}
