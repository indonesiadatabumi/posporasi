<?php

namespace App\Http\Controllers;

use App\Models\Printer;
use Illuminate\Http\Request;

class PrinterController extends Controller
{
    public function index()
    {
        $printer = Printer::where('id_resto', auth()->user()->restoran->id)->get();

        $defaultPrinter = Printer::where('id_resto', auth()->user()->restoran->id)
                                  ->where('is_default', 1)
                                  ->first();

        return view('printer.index', compact('printer', 'defaultPrinter'));
    }

    public function store(Request $request)
    {
        // Menentukan aturan validasi berdasarkan tipe koneksi
        $rules = [
            'nama_printer' => 'required|string|max:255',
            'koneksi' => 'required|in:network,usb,smb',
            'ip_printer' => 'nullable|ip',
            'port_printer' => 'nullable|numeric', // Membuat port optional
            'share_name' => 'nullable|string|max:255',
            'lokasi_printer' => 'nullable|string|max:255',
            'device' => 'nullable|string|max:255',
            'id_resto' => 'required|exists:restoran,id',
        ];
    
        // Jika koneksi adalah 'network', port_printer harus ada
        if ($request->koneksi == 'network') {
            $rules['port_printer'] = 'required|numeric'; // Menjadikan port wajib diisi jika koneksi network
        }
    
        // Validasi input dengan aturan yang sudah disesuaikan
        $validated = $request->validate($rules);
    
        // Menyimpan data printer
        Printer::create([
            'nama_printer' => $validated['nama_printer'],
            'koneksi' => $validated['koneksi'],
            'ip_printer' => $validated['ip_printer'],
            'port_printer' => $validated['port_printer'], // Pastikan port_printer tidak null jika koneksi adalah network
            'share_name' => $validated['share_name'],
            'lokasi_printer' => $validated['lokasi_printer'],
            'device' => $validated['device'],
            'id_resto' => auth()->user()->restoran->id, // Menggunakan restoran dari user yang login
            'is_default' => false, // Tidak menetapkan default saat menambah
        ]);
    
        // Mengalihkan kembali dengan pesan sukses
        return redirect()->route('printer.index')->with('success', 'Pengaturan printer berhasil disimpan');
    }
    
    public function setDefault(Printer $printer)
    {
        // Set printer lain sebagai non-default
        Printer::where('id_resto', auth()->user()->restoran->id)
               ->update(['is_default' => false]);

        // Set printer ini sebagai default
        $printer->update(['is_default' => true]);

        return redirect()->route('printer.index')->with('success', 'Printer berhasil diatur sebagai default');
    }
    
    public function destroy($id)
    {
        // Menghapus printer
        $printer = Printer::findOrFail($id);
        $printer->delete();

        return redirect()->route('printer.index')->with('success', 'Printer berhasil dihapus');
    }
}
