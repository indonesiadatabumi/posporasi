<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use Illuminate\Support\Facades\Auth;

class KitchenOrderController extends Controller
{
    public function index()
    {
        $idResto = Auth::user()->restoran->id;

        $orders = Pembelian::with('detail')->where('id_resto', $idResto)->get();

        foreach ($orders as $order) {
            $order->completed_count = $order->detail->where('status', 'complete')->count();
        }

        return view('kitchenorder.index', compact('orders'));
    }

    public function completeItem($id)
    {
        $item = PembelianDetail::find($id);

        if ($item) {
            $item->status = 'complete';  
            $item->save();
            return response()->json(['success' => true, 'message' => 'Pesanan berhasil diselesaikan.']);
        }

        return response()->json(['success' => false, 'message' => 'Item tidak ditemukan.']);
    }
}
