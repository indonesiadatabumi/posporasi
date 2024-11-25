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
        $rules = [
            'nama_printer' => 'required|string|max:255',
            'koneksi' => 'required|in:network,usb,smb',
            'ip_printer' => 'nullable|ip',
            'port_printer' => 'nullable|numeric',  
            'share_name' => 'nullable|string|max:255',
            'lokasi_printer' => 'nullable|string|max:255',
            'device' => 'nullable|string|max:255',
            'id_resto' => 'required|exists:restoran,id',
        ];
    
        if ($request->koneksi == 'network') {
            $rules['port_printer'] = 'required|numeric';  
        }
    
        $validated = $request->validate($rules);
    
        Printer::create([
            'nama_printer' => $validated['nama_printer'],
            'koneksi' => $validated['koneksi'],
            'ip_printer' => $validated['ip_printer'],
            'port_printer' => $validated['port_printer'],  
            'share_name' => $validated['share_name'],
            'lokasi_printer' => $validated['lokasi_printer'],
            'device' => $validated['device'],
            'id_resto' => auth()->user()->restoran->id,  
            'is_default' => false,  
        ]);
    
        return redirect()->route('printer.index')->with('success', 'Pengaturan printer berhasil disimpan');
    }
    
    public function setDefault(Printer $printer)
    {
        Printer::where('id_resto', auth()->user()->restoran->id)
               ->update(['is_default' => false]);

        $printer->update(['is_default' => true]);

        return redirect()->route('printer.index')->with('success', 'Printer berhasil diatur sebagai default');
    }
    
    public function destroy($id)
    {
        $printer = Printer::findOrFail($id);
        $printer->delete();

        return redirect()->route('printer.index')->with('success', 'Printer berhasil dihapus');
    }
}
