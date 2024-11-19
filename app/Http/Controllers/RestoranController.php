<?php

namespace App\Http\Controllers;

use App\Models\Restoran;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RestoranController extends Controller
{
    public function index()
    {
        return view('restoran.index');
    }

    public function data(Request $request)
    {
        $restoran = Restoran::select('id', 'nama_resto', 'nomor_identitas', 'email', 'alamat', 'nomor_telepon');
        
        return DataTables::of($restoran)
            ->addIndexColumn()  
            ->addColumn('action', function ($restoran) {
                return '
                    <form action="' . route('restoran.destroy', $restoran->id) . '" method="POST" style="display:inline;" class="delete-form">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin ingin menghapus?\')">Hapus</button>
                    </form>';
            })
            ->rawColumns(['action'])  
            ->make(true);
    }

    public function destroy($id)
    {
        $restoran = Restoran::findOrFail($id);
        
        $restoran->delete();

        return response()->json(['success' => 'Restoran berhasil dihapus!']);
    }
}
