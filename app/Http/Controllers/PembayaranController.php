<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Pembayaran;
use App\Models\Produk;
use App\Models\Meja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer as EscposPrinter; 
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use App\Models\Printer;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Mike42\Escpos\EscposImage;
use Barryvdh\DomPDF\Facade\Pdf;
use TCPDF;

class PembayaranController extends Controller
{

public function generateNomorStruk()
{
    $idToko = str_pad(Auth::user()->restoran->id, 5, '0', STR_PAD_LEFT);

    $tahun = now()->format('y');  
    $bulan = now()->format('m'); 
    $hari = now()->format('d');   

    $nomorUrut = Pembayaran::whereYear('created_at', now()->year)   
        ->whereMonth('created_at', now()->month) 
        ->where('id_resto', Auth::user()->restoran->id)  
        ->count() + 1;  

    $nomorUrut = str_pad($nomorUrut, 6, '0', STR_PAD_LEFT);

    $nomorStruk = $idToko . $tahun . $bulan . $hari . $nomorUrut;

    return $nomorStruk;
}

public function index()
{
    $pembelian = Pembelian::whereIn('status', ['pending', 'paid'])
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

        foreach ($pembelian->detail as $detail) {
            $produk = Produk::find($detail->id_produk);
            if ($produk) {
                $produk->stok += $detail->jumlah;
                $produk->save();
            }
        }

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
        $request->validate([
            'metode_pembayaran' => 'required|string|max:50',
            'pembelian_id' => 'required|integer',
            'total_pembayaran' => 'required|numeric|min:0',
            'tunai' => 'required|numeric|min:0',  // Validasi untuk tunai
        ]);
    
        $pembelian = Pembelian::with('detail')->find($request->pembelian_id);
    
        if (!$pembelian || $pembelian->id_resto !== (Auth::user()->restoran->id ?? 0) || $pembelian->status !== 'pending') {
            return response()->json(['message' => 'Pembelian tidak ditemukan atau Anda tidak memiliki akses.'], 404);
        }
    
        $subtotal = $pembelian->detail->sum(function ($detail) {
            return $detail->jumlah * $detail->harga_satuan;
        });
    
        $pajak = $subtotal * 0.10;
        $totalPembayaran = $subtotal + $pajak;
    
        if ($request->total_pembayaran < $totalPembayaran) {
            return response()->json(['message' => 'Total pembayaran tidak cukup.'], 400);
        }
    
        $nomor_struk = $this->generateNomorStruk();
    
        $pembayaran = new Pembayaran();
        $pembayaran->id_resto = Auth::user()->restoran->id;
        $pembayaran->id_user = Auth::id(); 
        $pembayaran->pembelian_id = $pembelian->id;
        $pembayaran->subtotal = $subtotal;
        $pembayaran->pajak = $pajak;
        $pembayaran->total_pembayaran = $totalPembayaran;
        $pembayaran->metode_pembayaran = $request->metode_pembayaran;
        $pembayaran->tunai = $request->tunai;  
        $pembayaran->nomor_struk = $nomor_struk;
    
        try {
            $pembayaran->save();
    
            if ($request->hasFile('nomor_struk')) {
                $file = $request->file('nomor_struk');
                
                $fileName = time() . '_' . $file->getClientOriginalName();
                
                $filePath = $file->storeAs('qrcode/struk', $fileName, 'public');
                
                $pembayaran->nomor_struk = $filePath;
                $pembayaran->save();
            }
    
            if ($pembelian->meja) {
                Meja::find($pembelian->meja->id)->update(['status' => 'tersedia']);
            }
    
            $pembelian->status = 'paid';
            $pembelian->save();
    
            $qrcode = QrCode::format('png')->size(150)->generate($nomor_struk);
    
            $filePathQRCode = 'qrcode/' . $nomor_struk . '.png';
            Storage::disk('public')->put($filePathQRCode, $qrcode);
    
            // Menghitung kembalian
            $kembalian = $request->tunai - $totalPembayaran;
    
            return response()->json([
                'message' => 'Pembayaran berhasil diproses!',
                'nomor_struk' => $nomor_struk,
                'qrcode' => $filePathQRCode,
                'file_struk' => $filePath ?? null,
                'kembalian' => $kembalian,  // Mengirimkan nilai kembalian
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage()], 500);
        }
    }
    
    // public function printReceipt(Request $request, $pembelianId)
    // {
    //     $pembelian = Pembelian::with('detail.produk')->find($pembelianId);
    //     $restoran = Auth::user()->restoran;
    
    //     if (!$pembelian) {
    //         return response()->json(['message' => 'Pembelian tidak ditemukan'], 404);
    //     }
    
    //     $pembayaran = Pembayaran::where('pembelian_id', $pembelianId)->first();
    
    //     if (!$pembayaran) {
    //         return response()->json(['message' => 'Pembayaran tidak ditemukan'], 404);
    //     }
    
    //     $nomor_struk = $pembayaran->nomor_struk;
    //     $amountPaid = $request->query('amountPaid', 0);
    //     $change = $request->query('change', 0);
    
    //     $jenisPesanan = $pembelian->jenis_pesanan ?? 'N/A';  
    //     if ($jenisPesanan == 'dine-in') {
    //         $jenisPesanan = 'Dine In';
    //     } elseif ($jenisPesanan == 'take-away') {
    //         $jenisPesanan = 'Take Away';
    //     }
    
    //     $defaultPrinter = Printer::where('is_default', 1)->first();
    //     if (!$defaultPrinter) {
    //         return response()->json(['message' => 'Printer default tidak ditemukan'], 404);
    //     }
    
    //     try {
    //         if ($defaultPrinter->koneksi === 'smb') {
    //             if (empty($defaultPrinter->device) || empty($defaultPrinter->share_name)) {
    //                 return response()->json(['message' => 'Konfigurasi printer SMB tidak lengkap'], 400);
    //             }
    //             $printerConnector = "smb://{$defaultPrinter->device}/{$defaultPrinter->share_name}";
    //             $connector = new WindowsPrintConnector($printerConnector);
    //         } elseif ($defaultPrinter->koneksi === 'network') {
    //             if (empty($defaultPrinter->ip_printer) || empty($defaultPrinter->port)) {
    //                 return response()->json(['message' => 'Konfigurasi printer jaringan tidak lengkap'], 400);
    //             }
    //             $connector = new NetworkPrintConnector($defaultPrinter->ip_printer, $defaultPrinter->port);
    //         } elseif ($defaultPrinter->koneksi === 'usb') {
    //             $printerConnector = "/dev/usb/lp0"; 
    //             $connector = new FilePrintConnector($printerConnector);
    //         } else {
    //             return response()->json(['message' => 'Koneksi printer tidak valid'], 400);
    //         }
    
    //         $thermalPrinter = new EscposPrinter($connector);
    //         $thermalPrinter->setFont(EscposPrinter::FONT_B);
    //         $thermalPrinter->setTextSize(2, 2);
    //         $thermalPrinter->setJustification(EscposPrinter::JUSTIFY_CENTER);
    //         $thermalPrinter->text("=== {$restoran->nama_resto} ===\n");
    
    //         $thermalPrinter->setFont(EscposPrinter::FONT_A);
    //         $thermalPrinter->setTextSize(1, 1);
    //         $thermalPrinter->text("Alamat: {$restoran->alamat}\n");
    //         $thermalPrinter->text("Telp: {$restoran->nomor_telepon}\n");
    //         $thermalPrinter->text("================================================\n");
    
    //         $thermalPrinter->setJustification(EscposPrinter::JUSTIFY_LEFT);
    //         $thermalPrinter->text("Customer      : " . $pembelian->pembeli . "\n");
    //         $thermalPrinter->text("No. Struk     : {$nomor_struk}\n");  
    //         $thermalPrinter->text("Jenis Pesanan : {$jenisPesanan}\n"); 
    //         $thermalPrinter->text("Tanggal       : " . now()->format('d-m-Y') . "\n");
    //         $thermalPrinter->text("================================================\n");
    
    //         $subtotal = 0;
    
    //         foreach ($pembelian->detail as $detail) {
    //             $namaProduk = $detail->produk->nama_produk;
    //             $jumlah = $detail->jumlah;
    //             $hargaSatuan = number_format($detail->harga_satuan, 0, ',', '.');
    
    //             $thermalPrinter->text(
    //                 str_pad($jumlah, 5, " ", STR_PAD_RIGHT) . 
    //                 str_pad($namaProduk, 35, " ") . 
    //                 str_pad($hargaSatuan, 7, " ", STR_PAD_LEFT) . "\n"
    //             );
    
    //             $subtotal += $detail->jumlah * $detail->harga_satuan;
    //         }
    
    //         $thermalPrinter->text("------------------------------------------------\n");
    //         $pajak = $subtotal * 0.10;  
    //         $grandTotal = $subtotal + $pajak;
    
    //         $thermalPrinter->setJustification(EscposPrinter::JUSTIFY_RIGHT);
    //         $thermalPrinter->text("Subtotal     : " . str_pad(number_format($subtotal, 0, ',', '.'), 12, " ", STR_PAD_LEFT) . "\n");
    //         $thermalPrinter->text("Pajak        : " . str_pad(number_format($pajak, 0, ',', '.'), 12, " ", STR_PAD_LEFT) . "\n");
    //         $thermalPrinter->text("---------------------------------\n");
    //         $thermalPrinter->text("Total Bayar  : " . str_pad(number_format($grandTotal, 0, ',', '.'), 12, " ", STR_PAD_LEFT) . "\n");
    //         $thermalPrinter->text("TUNAI        : " . str_pad(number_format($amountPaid, 0, ',', '.'), 12, " ", STR_PAD_LEFT) . "\n");
    //         $thermalPrinter->text("---------------------------------\n");
    //         $thermalPrinter->text("Kembalian    : " . str_pad(number_format($change, 0, ',', '.'), 12, " ", STR_PAD_LEFT) . "\n");
    
    //         $thermalPrinter->setJustification(EscposPrinter::JUSTIFY_CENTER);
    //         $thermalPrinter->text("================================================\n");
    //         $thermalPrinter->text("Terima kasih atas kunjungan Anda!\n");
    //         $thermalPrinter->text("Mohon simpan struk ini sebagai bukti pembayaran\n");
    
    //         $filePathQRCode = 'qrcode/' . $nomor_struk . '.png';
    //         if (Storage::disk('public')->exists($filePathQRCode)) {
    //             $filePath = storage_path('app/public/' . $filePathQRCode);
    //             $escposImage = EscposImage::load($filePath, false);
    //             $thermalPrinter->bitImage($escposImage);
    //         } else {
    //             return response()->json(['message' => 'QR Code tidak ditemukan.'], 500);
    //         }
    
    //         $thermalPrinter->cut(); 
    //     } catch (\Exception $e) {
    //         return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
    //     } finally {
    //         if (isset($thermalPrinter)) {
    //             $thermalPrinter->close();
    //         }
    //     }
    
    //     return response()->json(['message' => 'Struk berhasil dicetak!']);
    // }
    


    // public function printPDF($pembelianId)
    // {
    //     $pembelian = Pembelian::with('detail.produk')->find($pembelianId);
    //     $restoran = Auth::user()->restoran;

    //     if (!$pembelian) {
    //         return response()->json(['message' => 'Pembelian tidak ditemukan'], 404);
    //     }

    //     $pembayaran = Pembayaran::where('pembelian_id', $pembelianId)->first();

    //     if (!$pembayaran) {
    //         return response()->json(['message' => 'Pembayaran tidak ditemukan'], 404);
    //     }

    //     $nomor_struk = $pembayaran->nomor_struk;
    //     $subtotal = $pembelian->detail->sum(fn($detail) => $detail->jumlah * $detail->harga_satuan);
    //     $pajak = $subtotal * 0.10;
    //     $grandTotal = $subtotal + $pajak;

    //     $data = [
    //         'restoran' => $restoran,
    //         'pembelian' => $pembelian,
    //         'pembayaran' => $pembayaran,
    //         'subtotal' => $subtotal,
    //         'pajak' => $pajak,
    //         'grandTotal' => $grandTotal,
    //         'nomor_struk' => $nomor_struk,
    //     ];

    //     $pdf = Pdf::loadView('pdf.struk', $data);

    //     return $pdf->stream('struk-' . $nomor_struk . '.pdf');
    // }

    // public function printReceipt(Request $request, $pembelianId)
    // {
    //     $pembelian = Pembelian::with('detail.produk')->find($pembelianId);
    //     $restoran = Auth::user()->restoran;
    
    //     if (!$pembelian) {
    //         return response()->json(['message' => 'Pembelian tidak ditemukan'], 404);
    //     }
    
    //     $pembayaran = Pembayaran::where('pembelian_id', $pembelianId)->first();
    
    //     if (!$pembayaran) {
    //         return response()->json(['message' => 'Pembayaran tidak ditemukan'], 404);
    //     }
    
    //     $nomor_struk = $pembayaran->nomor_struk;
    //     $amountPaid = $request->query('amountPaid', 0);
    //     $change = $request->query('change', 0);
    
    //     $jenisPesanan = $pembelian->jenis_pesanan ?? 'N/A';
    //     if ($jenisPesanan == 'dine-in') {
    //         $jenisPesanan = 'Dine In';
    //     } elseif ($jenisPesanan == 'take-away') {
    //         $jenisPesanan = 'Take Away';
    //     }
    
    //     $pdf = new TCPDF('P', 'mm', array(48, 210));
    //     $pdf->SetAutoPageBreak(true, 5);
    //     $pdf->SetMargins(5, 5, 5);  
    //     $pdf->AddPage();
    
    //     $pdf->SetFont('helvetica', 'B', 10);   
    //     $headerText = utf8_decode("=== {$restoran->nama_resto} ===");
    //     $pdf->SetXY(($pdf->GetPageWidth() - $pdf->GetStringWidth($headerText)) / 2, 5);
    //     $pdf->Cell(0, 4, $headerText, 0, 1, 'C'); 
    
    //     $pdf->SetFont('helvetica', '', 6);   
    //     $alamatText = "Alamat: {$restoran->alamat}";
    //     $telpText = "Telp: {$restoran->nomor_telepon}";
    
    //     $pdf->SetXY(($pdf->GetPageWidth() - $pdf->GetStringWidth($alamatText)) / 2, 15);
    //     $pdf->Cell(0, 4, $alamatText, 0, 1, 'C'); 
    
    //     $pdf->SetXY(($pdf->GetPageWidth() - $pdf->GetStringWidth($telpText)) / 2, 22);
    //     $pdf->Cell(0, 4, $telpText, 0, 1, 'C'); 
    
    //     $pdf->SetXY(($pdf->GetPageWidth() - $pdf->GetStringWidth("===========================")) / 2, 29);
    //     $pdf->Cell(0, 4, "========================", 0, 1, 'C');  
    
    //     $pdf->SetFont('helvetica', '', 6);
    //     $pdf->SetXY(5, 40);
    //     $pdf->Cell(0, 4, "Customer      : {$pembelian->pembeli}", 0, 1, 'L');  
    //     $pdf->Cell(0, 4, "No. Struk     : {$nomor_struk}", 0, 1, 'L'); 
    //     $pdf->Cell(0, 4, "Jenis Pesanan : {$jenisPesanan}", 0, 1, 'L'); 
    //     $pdf->Cell(0, 4, "Tanggal       : " . now()->format('d-m-Y'), 0, 1, 'L');  
    //     $pdf->Cell(0, 4, "=====================", 0, 1, 'L'); 
    
    //     $subtotal = 0;
    //     $pdf->SetFont('helvetica', '', 6);   
    //     foreach ($pembelian->detail as $detail) {
    //         $namaProduk = $detail->produk->nama_produk;
    //         $jumlah = $detail->jumlah;
    //         $hargaSatuan = number_format($detail->harga_satuan, 0, ',', '.');
    
    //         $pdf->Cell(0, 4, "{$jumlah} x {$namaProduk} - {$hargaSatuan}", 0, 1, 'L');  
    //         $subtotal += $detail->jumlah * $detail->harga_satuan;
    //     }
    
    //     $pdf->Cell(0, 4, "--------------------------------", 0, 1, 'L'); 
    
    //     // Hitung pajak dan total
    //     $pajak = $subtotal * 0.10;
    //     $grandTotal = $subtotal + $pajak;
    
    //     $pdf->SetFont('helvetica', '', 6);   
    //     $pdf->Cell(0, 4, "Subtotal     : " . number_format($subtotal, 0, ',', '.'), 0, 1, 'R'); 
    //     $pdf->Cell(0, 4, "Pajak        : " . number_format($pajak, 0, ',', '.'), 0, 1, 'R'); 
    //     $pdf->Cell(0, 4, "Total Bayar  : " . number_format($grandTotal, 0, ',', '.'), 0, 1, 'R'); 
    //     $pdf->Cell(0, 4, "TUNAI        : " . number_format($amountPaid, 0, ',', '.'), 0, 1, 'R');  
    //     $pdf->Cell(0, 4, "Kembalian    : " . number_format($change, 0, ',', '.'), 0, 1, 'R'); 
    
    //     $pdf->SetFont('helvetica', 'I', 6);  
    //     $pdf->Cell(0, 4, "===============================", 0, 1, 'C');  
    //     $pdf->Cell(0, 4, "Terima kasih atas kunjungan Anda!", 0, 1, 'C');  
    //     $pdf->Cell(0, 4, "Mohon simpan struk ini sebagai bukti pembayaran", 0, 1, 'C');  
    
    //     $filePathQRCode = 'qrcode/' . $nomor_struk . '.png';
    //     if (Storage::disk('public')->exists($filePathQRCode)) {
    //         $filePath = storage_path('app/public/' . $filePathQRCode);
    //         $pdf->Image($filePath, 5, $pdf->GetY(), 20, 20, 'PNG');
    //     } else {
    //         return response()->json(['message' => 'QR Code tidak ditemukan.'], 500);
    //     }
    
    //     $filePath = storage_path('app/public/struk/' . $nomor_struk . '.pdf');
    //     $pdf->Output($filePath, 'F');  
    
    //     return response()->json(['message' => 'Struk berhasil disimpan sebagai PDF', 'file' => $filePath]);
    // }
    
    public function printReceipt(Request $request, $pembelianId)
    {
        // Mengambil data pembelian dan relasi produk
        $pembelian = Pembelian::with('detail.produk')->find($pembelianId);
        $restoran = Auth::user()->restoran;
    
        if (!$pembelian) {
            return response()->json(['message' => 'Pembelian tidak ditemukan'], 404);
        }
    
        // Mengambil data pembayaran berdasarkan ID pembelian
        $pembayaran = Pembayaran::where('pembelian_id', $pembelianId)->first();
    
        if (!$pembayaran) {
            return response()->json(['message' => 'Pembayaran tidak ditemukan'], 404);
        }
    
        $nomor_struk = $pembayaran->nomor_struk;
    
        // Ambil jumlah tunai yang dibayar dari database
        $tunai = $pembayaran->tunai;  // Ambil tunai dari kolom 'tunai' di tabel Pembayaran
        $kembalian = $tunai - $pembayaran->total_pembayaran;  // Menghitung kembalian
    
        // Mengatur jenis pesanan
        $jenisPesanan = $pembelian->jenis_pesanan ?? 'N/A';
        $jenisPesanan = $jenisPesanan === 'dine-in' ? 'Dine In' : ($jenisPesanan === 'take-away' ? 'Take Away' : $jenisPesanan);
    
        // Menghitung subtotal dan mendata detail pembelian
        $subtotal = 0;
        $details = $pembelian->detail->map(function ($detail) use (&$subtotal) {
            $subtotal += $detail->jumlah * $detail->harga_satuan;
            return [
                'nama_produk' => $detail->produk->nama_produk,
                'jumlah' => $detail->jumlah,
                'harga_satuan' => $detail->harga_satuan,
            ];
        });
    
        // Menghitung pajak dan total pembayaran
        $pajak = $subtotal * 0.10;
        $grandTotal = $subtotal + $pajak;
    
        // Mengirim data ke view
        return view('pembayaran.print', [ 
            'restoran' => $restoran,
            'pembelian' => $pembelian,
            'nomor_struk' => $nomor_struk,
            'jenisPesanan' => $jenisPesanan,
            'details' => $details,
            'subtotal' => $subtotal,
            'pajak' => $pajak,
            'grandTotal' => $grandTotal,
            'tunai' => $tunai,  // Kirimkan nilai tunai ke view
            'kembalian' => $kembalian,  // Kirimkan kembalian ke view
        ]);
    }
    
    public function selesai($id)
    {
        $pembelian = Pembelian::find($id);
    
        if ($pembelian) {
            $pembelian->status = 'completed';
            $pembelian->save();
    
            \Log::info('Pembelian berhasil diselesaikan', ['id' => $id, 'status' => 'completed']);
    
            return response()->json(['success' => true]);
        }
    
        \Log::error('Pembelian tidak ditemukan', ['id' => $id]);
    
        return response()->json(['success' => false], 400);
    }
    
}
