<?php

namespace App\Http\Controllers;

use App\Models\Produk; // Pastikan untuk mengimpor model Produk
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Impor Auth untuk mendapatkan ID pengguna yang sedang login

class KitchenController extends Controller
{
    public function index()
    {
        // Ambil produk yang terkait dengan kategori berdasarkan id_resto yang sedang login
        $produk = Produk::whereHas('kategori', function($query) {
            $query->where('id_resto', Auth::user()->id_resto); // Filter produk berdasarkan id_resto
        })->get();

        return view('kitchen.index', compact('produk'));
    }
}
