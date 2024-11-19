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

    public function data()
    {
        $pembayaran = Pembayaran::where('id_resto', Auth::user()->restoran->id)->get();

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

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'metode_pembayaran' => 'required|string|max:50',
            'subtotal' => 'required|numeric',
            'pajak' => 'required|numeric',
            'total_pembayaran' => 'required|numeric',
            'nomor_struk' => 'nullable|string|max:50',
        ]);

        $validatedData['id_resto'] = Auth::user()->restoran->id;

        Pembayaran::create($validatedData);

        return response()->json(['success' => 'Pembayaran berhasil ditambahkan.']);
    }
    public function cetakPdf(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
    
        $query = Pembayaran::where('id_resto', Auth::user()->restoran->id);
    
        if ($start_date) {
            $query->whereDate('created_at', '>=', $start_date);
        }
        if ($end_date) {
            $query->whereDate('created_at', '<=', $end_date);
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
            'current_date' => \Carbon\Carbon::now()->format('d-m-Y'),
        ];
    
        $pdf = PDF::loadView('lpembayaran.pdf', $data)->setPaper('a4', 'potrait');
    
        return $pdf->download('laporan_pembayaran_' . \Carbon\Carbon::now()->format('d_m_Y') . '.pdf');
    }
    
}
