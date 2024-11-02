<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Produk;
use App\Models\Meja;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembelianController extends Controller
{
    public function index()
    {
        $produk = Produk::orderBy('stok', 'desc')->whereHas('kategori', function ($query) {
            $query->where('id_resto', Auth::user()->restoran->id);
        })->get();

        $kategori = Kategori::where('id_resto', Auth::user()->restoran->id)->get();

        $meja = Meja::where('id_resto', Auth::user()->restoran->id)->get();

        return view('pembelian.index', compact('produk', 'kategori', 'meja'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'items' => 'required|array',
            'total_price' => 'required|numeric',
            'jenis_pesanan' => 'required|in:dine-in,take-away',
            'meja_id' => 'nullable',
        ]);
    
        // Menghasilkan no_order
        $no_order = $this->generateOrderNumber();
    
        $pembelian = new Pembelian();
        $pembelian->no_order = $no_order; // Set no_order
        $pembelian->pembeli = $validated['customer_name'];
        $pembelian->total_harga = $validated['total_price'];
        $pembelian->pajak = $validated['total_price'] * 0.1;
        $pembelian->status = 'pending';
        $pembelian->jenis_pesanan = $validated['jenis_pesanan'];
        $pembelian->id_resto = Auth::user()->restoran->id;
    
        // Logika untuk mengatur meja
        if ($validated['jenis_pesanan'] === 'dine-in') {
            $pembelian->id_meja = $validated['meja_id'];
            $meja = Meja::find($validated['meja_id']);
            if ($meja->status === 'tidak tersedia') {
                return response()->json(['message' => 'Meja sudah tidak tersedia.'], 400);
            }
            $meja->status = 'tidak tersedia';
            $meja->save();
        }
    
        $pembelian->save();
    
        // Menyimpan detail pembelian
        foreach ($validated['items'] as $item) {
            $produk = Produk::findOrFail($item['id']);
            if ($produk->stok < $item['quantity']) {
                return response()->json(['message' => 'Stok tidak cukup untuk produk: ' . $produk->nama_produk], 400);
            }
    
            $produk->stok -= $item['quantity'];
            $produk->save();
    
            $pembelianDetail = new PembelianDetail();
            $pembelianDetail->id_pembelian = $pembelian->id;
            $pembelianDetail->id_produk = $item['id'];
            $pembelianDetail->jumlah = $item['quantity'];
            $pembelianDetail->harga_satuan = $item['price'];
            $pembelianDetail->total_harga = $item['price'] * $item['quantity'];
            $pembelianDetail->status = 'cook';
            $pembelianDetail->save();
        }
    
        return response()->json(['message' => 'Checkout berhasil!', 'pembelian' => $pembelian]);
    }
    
    public function checkout(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string',
            'items' => 'required|array',
            'total_price' => 'required|numeric',
            'status' => 'required|string',
            'meja_id' => 'nullable|exists:meja,id',
            'jenis_pesanan' => 'required|in:dine-in,take-away',
        ]);
    
        // Menghasilkan no_order
        $no_order = $this->generateOrderNumber();
    
        $pembelian = new Pembelian();
        $pembelian->no_order = $no_order; // Set no_order
        $pembelian->pembeli = $request->customer_name;
        $pembelian->total_harga = $request->total_price;
        $pembelian->status = $request->status;
        $pembelian->pajak = $request->total_price * 0.1;
        $pembelian->jenis_pesanan = $request->jenis_pesanan;
        $pembelian->id_resto = Auth::user()->restoran->id;
    
        // Logika untuk mengatur meja
        if ($request->jenis_pesanan === 'dine-in') {
            $meja = Meja::find($request->meja_id);
            if ($meja->status === 'tidak tersedia') {
                return response()->json(['message' => 'Meja sudah tidak tersedia.'], 400);
            }
            $meja->status = 'tidak tersedia';
            $meja->save();
            $pembelian->id_meja = $request->meja_id;
        }
    
        $pembelian->save();
    
        // Menyimpan detail pembelian
        foreach ($request->items as $item) {
            $produk = Produk::find($item['id']);
            if ($produk->stok < $item['quantity']) {
                return response()->json(['message' => 'Stok tidak cukup untuk produk: ' . $produk->nama_produk], 400);
            }
    
            $produk->stok -= $item['quantity'];
            $produk->save();
    
            $pembelianDetail = new PembelianDetail();
            $pembelianDetail->id_pembelian = $pembelian->id;
            $pembelianDetail->id_produk = $item['id'];
            $pembelianDetail->jumlah = $item['quantity'];
            $pembelianDetail->harga_satuan = $item['price'];
            $pembelianDetail->total_harga = $item['price'] * $item['quantity'];
            $pembelianDetail->status = 'cook';
            $pembelianDetail->save();
        }
    
        return response()->json(['message' => 'Checkout berhasil!', 'pembelian' => $pembelian]);
    }
    
    private function generateOrderNumber()
    {
        $today = date('Y-m-d');
        $lastOrder = Pembelian::whereDate('created_at', $today)->orderBy('no_order', 'desc')->first();
        
        if ($lastOrder) {
            $lastNumber = (int)substr($lastOrder->no_order, 1); // Mengambil bagian angka dari no_order
            $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '00001'; // Jika tidak ada, mulai dari 00001
        }
    
        return '#' . $newNumber; // Kembalikan dengan format #
    }
    
    public function edit($id)
    {
        $pembelian = Pembelian::with(['detail.produk', 'meja'])
            ->where('id', $id)
            ->where('id_resto', Auth::user()->restoran->id)
            ->firstOrFail();
        $kategori = Kategori::where('id_resto', Auth::user()->restoran->id)->get();
        $meja = Meja::where('id_resto', Auth::user()->restoran->id)->orWhere('id', $pembelian->id_meja)->get();
        $produk = Produk::orderBy('stok', 'desc')->whereHas('kategori', function ($query) {
            $query->where('id_resto', Auth::user()->restoran->id);
        })->get();
    
        return view('pembelian.edit', compact('pembelian', 'meja', 'kategori', 'produk'));
    }
    

    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'customer_name' => 'required|string|max:255',
        'items' => 'required|array',
        'total_price' => 'required|numeric',
        'status' => 'required|string',
        'meja_id' => 'nullable|exists:meja,id',
        'jenis_pesanan' => 'required|in:dine-in,take-away',
    ]);

    $pembelian = Pembelian::with('detail')->find($id);
    if (!$pembelian || $pembelian->id_resto !== Auth::user()->restoran->id) {
        return response()->json(['message' => 'Pembelian tidak ditemukan.'], 404);
    }

    foreach ($pembelian->detail as $detail) {
        $produk = Produk::find($detail->id_produk);
        $produk->stok += $detail->jumlah;
        $produk->save();
    }

    $pembelian->pembeli = $validated['customer_name'];
    $pembelian->total_harga = $validated['total_price'];
    $pembelian->status = $validated['status'];
    $pembelian->pajak = $validated['total_price'] * 0.1;
    $pembelian->jenis_pesanan = $validated['jenis_pesanan'];

    if ($validated['jenis_pesanan'] === 'dine-in') {
        $meja = Meja::find($validated['meja_id']);
        if (!$meja) {
            return response()->json(['message' => 'Meja tidak ditemukan.'], 404);
        }
    
        if ($pembelian->id_meja && $pembelian->id_meja !== $validated['meja_id']) {
            $oldMeja = Meja::find($pembelian->id_meja);
            if ($oldMeja) {
                $oldMeja->status = 'tersedia'; 
                $oldMeja->save();
            }
        }
    
        if ($meja->status === 'tidak tersedia') {
            return response()->json(['message' => 'Meja sudah tidak tersedia.'], 400);
        }
    
        $meja->status = 'tidak tersedia';
        $meja->save();
        $pembelian->id_meja = $validated['meja_id'];
    }
    $pembelian->save();

    $pembelian->detail()->delete();

    foreach ($validated['items'] as $item) {
        $produk = Produk::find($item['id']);
        if ($produk->stok < $item['quantity']) {
            return response()->json(['message' => 'Stok tidak cukup untuk produk: ' . $produk->nama_produk], 400);
        }
        $produk->stok -= $item['quantity'];
        $produk->save();

        $pembelianDetail = new PembelianDetail();
        $pembelianDetail->id_pembelian = $pembelian->id;
        $pembelianDetail->id_produk = $item['id'];
        $pembelianDetail->jumlah = $item['quantity'];
        $pembelianDetail->harga_satuan = $item['price'];
        $pembelianDetail->total_harga = $item['price'] * $item['quantity'];
        $pembelianDetail->status = 'cook';
        $pembelianDetail->save();
    }

    return response()->json(['message' => 'Pembelian berhasil diperbarui!']);
}


    // public function checkout(Request $request)
    // {
    //     $request->validate([
    //         'customer_name' => 'required|string',
    //         'items' => 'required|array',
    //         'total_price' => 'required|numeric',
    //         'status' => 'required|string',
    //         'meja_id' => 'nullable|exists:meja,id', 
    //         'jenis_pesanan' => 'required|in:dine-in,take-away',  
    //     ]);

    //     $pembelian = new Pembelian();
    //     $pembelian->pembeli = $request->customer_name;
    //     $pembelian->total_harga = $request->total_price;
    //     $pembelian->status = $request->status;
    //     $pembelian->pajak = $request->total_price * 0.1;
    //     $pembelian->jenis_pesanan = $request->jenis_pesanan;  
    //     $pembelian->id_resto = Auth::user()->restoran->id;

    //     if ($request->jenis_pesanan === 'dine-in') {
    //         $meja = Meja::find($request->meja_id);
    //         if ($meja->status === 'tidak tersedia') {
    //             return response()->json(['message' => 'Meja sudah tidak tersedia.'], 400);
    //         }
    //         $meja->status = 'tidak tersedia';
    //         $meja->save();
    //         $pembelian->id_meja = $request->meja_id;
    //     }

    //     $pembelian->save();

    //     foreach ($request->items as $item) {
    //         $produk = Produk::find($item['id']);
    //         if ($produk->stok < $item['quantity']) {
    //             return response()->json(['message' => 'Stok tidak cukup untuk produk: ' . $produk->nama_produk], 400);
    //         }

    //         $produk->stok -= $item['quantity'];
    //         $produk->save();

    //         $pembelianDetail = new PembelianDetail();
    //         $pembelianDetail->id_pembelian = $pembelian->id;
    //         $pembelianDetail->id_produk = $item['id'];
    //         $pembelianDetail->jumlah = $item['quantity'];
    //         $pembelianDetail->harga_satuan = $item['price'];
    //         $pembelianDetail->total_harga = $item['price'] * $item['quantity'];
    //         $pembelianDetail->status = 'cook'; 
    //         $pembelianDetail->save();
    //     }

    //     return response()->json(['message' => 'Checkout berhasil!', 'pembelian' => $pembelian]);
    // }
}
