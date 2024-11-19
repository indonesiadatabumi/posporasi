<?php
namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\User;
use App\Models\Restoran;
use App\Models\Pembayaran;
use App\Models\PembelianDetail; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class MainController extends Controller {
 


    public function dashboard() {
        $jumlahUser = User::count();
        $jumlahRestoran = Restoran::count();
        // Data pemasukan harian
        $pemasukanHarian = Pembayaran::whereDate('created_at', today())
            ->where('id_resto', Auth::user()->restoran->id)
            ->sum('total_pembayaran');
    
        // Data pemasukan bulanan
        $pemasukanBulanan = Pembayaran::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->where('id_resto', Auth::user()->restoran->id)
            ->sum('total_pembayaran');
    
        // Pendapatan bulan ini
        $pendapatanBulanIni = Pembayaran::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->where('id_resto', Auth::user()->restoran->id)
            ->sum('total_pembayaran');
    
        // Menghitung jumlah transaksi hari ini
        $jumlahTransaksiHariIni = Pembelian::whereDate('created_at', today())
            ->where('id_resto', Auth::user()->restoran->id)
            ->count();
    
        // Menghitung jumlah transaksi bulan ini
        $jumlahTransaksiBulanIni = Pembelian::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->where('id_resto', Auth::user()->restoran->id)
            ->count();
    
        // Menghitung produk paling laku bulan ini
        $produkPalingLaku = PembelianDetail::select('id_produk', \DB::raw('SUM(jumlah) as total_jumlah'))
            ->join('pembelian', 'pembelian_detail.id_pembelian', '=', 'pembelian.id')
            ->whereMonth('pembelian.created_at', now()->month)
            ->whereYear('pembelian.created_at', now()->year)
            ->where('pembelian.id_resto', Auth::user()->restoran->id)  
            ->groupBy('id_produk')
            ->orderBy('total_jumlah', 'DESC')
            ->limit(1)  
            ->with('produk')  
            ->first();
    
        return view('dashboard', compact('jumlahUser','jumlahRestoran','jumlahTransaksiHariIni', 'jumlahTransaksiBulanIni', 'pemasukanBulanan', 'pemasukanHarian', 'produkPalingLaku', 'pendapatanBulanIni'));
    }
    
    public function getMonthlyIncomeData()
    {
        $restoranId = Auth::user()->restoran->id;
        
        $pemasukanBulanan = Pembayaran::where('id_resto', $restoranId)
            ->selectRaw('MONTH(created_at) as bulan, SUM(total_pembayaran) as total_pemasukan')
            ->whereYear('created_at', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();
    
        return response()->json($pemasukanBulanan);
    }
    
}
