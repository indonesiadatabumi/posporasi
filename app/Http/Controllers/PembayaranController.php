<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Produk;
use App\Models\Meja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembelian = Pembelian::where('status', 'pending')
            ->where('id_resto', Auth::user()->restoran->id ?? 0)
            ->get();

        return view('pembayaran.index', compact('pembelian'));
    }

    public function ambilPembelian($id)
    {
        $pembelian = Pembelian::with('detail.produk')->find($id);

        if (!$pembelian || $pembelian->id_resto !== (Auth::user()->restoran->id ?? 0)) {
            return response()->json(['message' => 'Pembelian tidak ditemukan.'], 404);
        }

        return response()->json([
            'pembelian_id' => $id,
            'pembeli' => $pembelian->pembeli,
            'detail' => $pembelian->detail,
            'total_harga' => $pembelian->total_harga,
            'pajak' => $pembelian->pajak,
        ]);
    }

    public function destroy($id)
    {
        $pembelian = Pembelian::with('detail', 'meja')->find($id);

        if (!$pembelian || $pembelian->id_resto !== (Auth::user()->restoran->id ?? 0)) {
            return response()->json(['message' => 'Pembelian tidak ditemukan atau Anda tidak memiliki akses.'], 404);
        }

        // Mengembalikan stok produk
        foreach ($pembelian->detail as $detail) {
            $produk = Produk::find($detail->id_produk);
            if ($produk) {
                $produk->stok += $detail->jumlah;
                $produk->save();
            }
        }

        // Mengubah status meja jika ada
        if ($pembelian->meja) {
            $meja = Meja::find($pembelian->id_meja);
            if ($meja) {
                $meja->status = 'tersedia';
                $meja->save();
            }
        }

        $pembelian->detail()->delete();
        $pembelian->delete();

        return response()->json(['message' => 'Pembelian berhasil dihapus!']);
    }

    public function bayar(Request $request)
    {
        // Validasi input
        $request->validate([
            'metode_pembayaran' => 'required|string|max:50',
            'pembelian_id' => 'required|integer',
            'total_pembayaran' => 'required|numeric|min:0',
        ]);

        $pembelian = Pembelian::with('detail')->find($request->pembelian_id);

        // Validasi pembelian
        if (!$pembelian || $pembelian->id_resto !== (Auth::user()->restoran->id ?? 0) || $pembelian->status !== 'pending') {
            return response()->json(['message' => 'Pembelian tidak ditemukan atau Anda tidak memiliki akses.'], 404);
        }

        // Hitung subtotal dan pajak
        $subtotal = $pembelian->detail->sum(function ($detail) {
            return $detail->jumlah * $detail->harga_satuan;
        });

        $pajak = $subtotal * 0.10;
        $totalPembayaran = $subtotal + $pajak;

        // Validasi total pembayaran
        if ($request->total_pembayaran < $totalPembayaran) {
            return response()->json(['message' => 'Total pembayaran tidak cukup.'], 400);
        }

        $nomor_struk = "TRX-" . now()->format('YmdHis');

        // Simpan pembayaran
        $pembayaran = new \App\Models\Pembayaran();
        $pembayaran->id_resto = Auth::user()->restoran->id;
        $pembayaran->pembelian_id = $pembelian->id;
        $pembayaran->subtotal = $subtotal;
        $pembayaran->pajak = $pajak;
        $pembayaran->total_pembayaran = $totalPembayaran;
        $pembayaran->metode_pembayaran = $request->metode_pembayaran;
        $pembayaran->nomor_struk = $nomor_struk;

        try {
            $pembayaran->save();

            if ($pembelian->meja) {
                Meja::find($pembelian->meja->id)->update(['status' => 'tersedia']);
            }

            $pembelian->status = 'completed';
            $pembelian->save();

            return response()->json(['message' => 'Pembayaran berhasil diproses!', 'nomor_struk' => $nomor_struk]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage()], 500);
        }
    }

    public function printReceipt(Request $request, $pembelianId)
    {
        $pembelian = Pembelian::with('detail.produk')->find($pembelianId);
        $restoran = Auth::user()->restoran;
    
        if (!$pembelian) {
            return response()->json(['message' => 'Pembelian tidak ditemukan'], 404);
        }
    
        $amountPaid = $request->query('amountPaid', 0);
        $change = $request->query('change', 0);
        
        $nomor_struk = $pembelian->nomor_struk ?? 'N/A'; 
        $jenisPesanan = $pembelian->jenis_pesanan ?? 'N/A';  
    
        if ($jenisPesanan == 'dine-in') {
            $jenisPesanan = 'Dine In';
        } elseif ($jenisPesanan == 'take-away') {
            $jenisPesanan = 'Take Away';
        } else {
            $jenisPesanan = 'N/A';  
        }
    
        try {
            $connector = new WindowsPrintConnector("XP-58C");
            $printer = new Printer($connector);
    
            $printer->setFont(Printer::FONT_B);
            $printer->setTextSize(2, 2);
    
            $nama_resto = $restoran->nama_resto;
    
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("=== {$nama_resto} ===\n");
    
            $alamat = $restoran->alamat;
            $nomorTelepon = $restoran->nomor_telepon;
    
            $printer->setFont(Printer::FONT_A);
            $printer->setTextSize(1, 1);
            $printer->text("Alamat: {$alamat}\n");
            $printer->text("Telp: {$nomorTelepon}\n");
            $printer->text("================================================\n");
    
            $printer->setFont(Printer::FONT_A);
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->setTextSize(1, 1);
            $printer->text("Customer      : " . $pembelian->pembeli . "\n");
            $nomorStruk = $pembelian->nomor_struk ?? "TRX-" . now()->format('YmdHis');
            $printer->text("No. Struk     : {$nomorStruk}\n");
            $printer->text("Jenis Pesanan : {$jenisPesanan}\n"); 
            $printer->text("Tanggal       : " . now()->format('d-m-Y') . "\n");
            $printer->text("================================================\n");
    
            $subtotal = 0;
    
            foreach ($pembelian->detail as $detail) {
                $namaProduk = $detail->produk->nama_produk;
                $jumlah = $detail->jumlah;
                $hargaSatuan = number_format($detail->harga_satuan, 0, ',', '.');
    
                $printer->text(
                    str_pad($jumlah, 5, " ", STR_PAD_RIGHT) .
                    str_pad($namaProduk, 35, " ") .
                    str_pad($hargaSatuan, 7, " ", STR_PAD_LEFT) . "\n"
                );
    
                $subtotal += $detail->jumlah * $detail->harga_satuan;
            }
    
            $printer->text("------------------------------------------------\n");
    
            $pajak = $subtotal * 0.10;
            $grandTotal = $subtotal + $pajak;
    
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
    
            $printer->text("Subtotal     : " . str_pad(number_format($subtotal, 0, ',', '.'), 12, " ", STR_PAD_LEFT) . "\n");
            $printer->text("Pajak        : " . str_pad(number_format($pajak, 0, ',', '.'), 12, " ", STR_PAD_LEFT) . "\n");
            $printer->text("---------------------------------\n");
            $printer->text("Total Bayar  : " . str_pad(number_format($grandTotal, 0, ',', '.'), 12, " ", STR_PAD_LEFT) . "\n");
            $printer->text("TUNAI        : " . str_pad(number_format($amountPaid, 0, ',', '.'), 12, " ", STR_PAD_LEFT) . "\n");
            $printer->text("---------------------------------\n");
            $printer->text("Kembalian    : " . str_pad(number_format($change, 0, ',', '.'), 12, " ", STR_PAD_LEFT) . "\n");
    
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("================================================\n");
            $printer->text("Terima kasih atas kunjungan Anda!\n");
            $printer->text("Mohon simpan struk ini sebagai bukti pembayaran\n");

            $printer->cut(); 

            $printer->text("\n\n\n\n\n");  
            
            $printer->close();  
            
            return response()->json(['message' => 'Struk berhasil dicetak.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal mencetak struk: ' . $e->getMessage()], 500);
        }
    }
}
