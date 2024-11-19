<?php

namespace App\Http\Controllers;

use App\Models\PembelianDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;

class LPenjualanController extends Controller
{
    public function index()
    {
        return view('lpenjualan.index');
    }

    public function data(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $restoId = Auth::user()->restoran->id;

        $query = PembelianDetail::with('produk')
            ->whereHas('pembelian', function ($q) use ($restoId) {
                $q->where('id_resto', $restoId);
            });

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->input('start_date'));
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->input('end_date'));
        }

        $pembelianDetails = $query->select(
            'id_produk',
            DB::raw('DATE(created_at) as tanggal_transaksi'),
            DB::raw('SUM(jumlah) as total_terjual')
        )
        ->groupBy('id_produk', 'tanggal_transaksi')
        ->orderBy('tanggal_transaksi', 'asc')
        ->orderBy('id_produk', 'asc')
        ->get();

        $data = $pembelianDetails->map(function ($row) {
            $hargaJual = $row->produk->harga_jual ?? 0;
            $pendapatan = $hargaJual * $row->total_terjual;

            return [
                'tanggal_transaksi' => $row->tanggal_transaksi ? Carbon::parse($row->tanggal_transaksi)->format('d-m-Y') : '-',
                'nama_produk' => $row->produk->nama_produk ?? 'N/A',
                'kode_produk' => $row->produk->kode_produk ?? 'N/A',
                'terjual' => $row->total_terjual,
                'harga_jual' => 'Rp. ' . number_format($hargaJual, 0, ',', '.'),
                'pendapatan' => 'Rp. ' . number_format($pendapatan, 0, ',', '.'),
            ];
        });

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function () {
                return '';
            })
            ->make(true);
    }

    public function cetakPdf(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $restoId = Auth::user()->restoran->id;

        $query = PembelianDetail::with('produk')
            ->whereHas('pembelian', function ($q) use ($restoId) {
                $q->where('id_resto', $restoId);
            });

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $pembelianDetails = $query->select(
            'id_produk',
            DB::raw('DATE(created_at) as tanggal_transaksi'),
            DB::raw('SUM(jumlah) as total_terjual')
        )
        ->groupBy('id_produk', 'tanggal_transaksi')
        ->orderBy('tanggal_transaksi', 'asc')
        ->orderBy('id_produk', 'asc')
        ->get();

        $data = $pembelianDetails->map(function ($row) {
            $hargaJual = $row->produk->harga_jual ?? 0;
            $pendapatan = $hargaJual * $row->total_terjual;

            return [
                'tanggal_transaksi' => $row->tanggal_transaksi ? Carbon::parse($row->tanggal_transaksi)->format('d-m-Y') : '-',
                'nama_produk' => $row->produk->nama_produk ?? 'N/A',
                'kode_produk' => $row->produk->kode_produk ?? 'N/A',
                'terjual' => $row->total_terjual,
                'harga_jual' => 'Rp. ' . number_format($hargaJual, 0, ',', '.'),
                'pendapatan' => 'Rp. ' . number_format($pendapatan, 0, ',', '.'),
            ];
        });
        $tanggalCetak = Carbon::now()->format('d-m-Y');
        $pdf = PDF::loadView('lpenjualan.lpenjualan_pdf',compact('data', 'tanggalCetak') ,[
            'data' => $data,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'current_date' => Carbon::now()->format('d-m-Y'),
        ])->setPaper('a4', 'potrait');

        return $pdf->download('laporan_penjualan_' . Carbon::now()->format('d_m_Y') . '.pdf');
    }
}
