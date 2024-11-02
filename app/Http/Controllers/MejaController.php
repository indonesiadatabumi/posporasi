<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meja;
use Illuminate\Support\Facades\Auth; // Pastikan ini ada
use Yajra\DataTables\DataTables; // Jika menggunakan DataTables

class MejaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('meja.index'); 
    }

    public function data()
    {
        // Ambil meja yang sesuai dengan id_resto dari pengguna yang sedang login
        $meja = Meja::where('id_resto', Auth::user()->restoran->id)->get();

        return DataTables::of($meja)
            ->addIndexColumn()
            ->addColumn('aksi', function ($meja) {
                return '
                <div class="btn-group">
                    <button onclick="editForm(`'. route('meja.update', $meja->id) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button onclick="deleteData(`'. route('meja.destroy', $meja->id) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Jika diperlukan, bisa mengembalikan view untuk form create meja
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi untuk memastikan tidak ada nomor meja yang sama untuk pengguna ini
        $request->validate([
            'nomor_meja' => 'required|string|unique:meja,nomor_meja,NULL,id,id_resto,' . Auth::user()->restoran->id,
            'kapasitas' => 'required|integer', // Validasi untuk kapasitas
            'status' => 'required|string|in:tersedia,tidak_tersedia', // Validasi untuk status
        ], [
            'nomor_meja.unique' => 'Nomor meja sudah ada', // Pesan khusus jika meja sudah ada
        ]);

        $meja = new Meja();
        $meja->nomor_meja = $request->nomor_meja;
        $meja->kapasitas = $request->kapasitas; // Menyimpan kapasitas
        $meja->id_resto = Auth::user()->restoran->id; // Mengambil id_resto dari pengguna yang login
        $meja->status = 'tersedia'; // Status default
        $meja->save();

        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $meja = Meja::find($id);

        return response()->json($meja);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Jika diperlukan, bisa mengembalikan view untuk form edit meja
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validasi untuk memastikan tidak ada nomor meja yang sama untuk pengguna ini, kecuali meja itu sendiri
        $request->validate([
            'nomor_meja' => 'required|string|unique:meja,nomor_meja,' . $id . ',id,id_resto,' . Auth::user()->restoran->id,
            'kapasitas' => 'required|integer', // Validasi untuk kapasitas
            'status' => 'required|string|in:tersedia,tidak_tersedia', // Validasi untuk status
        ]);

        $meja = Meja::find($id);
        $meja->nomor_meja = $request->nomor_meja;
        $meja->kapasitas = $request->kapasitas; // Update kapasitas
        $meja->status = $request->status; // Update status
        $meja->save();

        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $meja = Meja::find($id);
        $meja->delete();

        return response(null, 204);
    }
}
