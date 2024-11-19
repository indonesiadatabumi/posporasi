<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth; // Pastikan ini ada

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('kategori.index');
    }

    public function data()
    {
        $kategori = Kategori::where('id_resto', Auth::user()->restoran->id)
            ->select(['id', 'nama_kategori', 'icon'])  
            ->get();
    
        return Datatables()
            ->of($kategori)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kategori) {
                return '
                <div class="btn-group">
                    <button onclick="editForm(`'. route('kategori.update', $kategori->id) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button onclick="deleteData(`'. route('kategori.destroy', $kategori->id) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'icon'])  
            ->make(true);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function store(Request $request)
     {
         $request->validate([
             'nama_kategori' => 'required|string|unique:kategori,nama_kategori,NULL,id,id_resto,' . Auth::id(),
             'icon' => 'nullable|string',
         ]);
     
         $kategori = new Kategori();
         $kategori->nama_kategori = $request->nama_kategori;
         $kategori->icon = $request->icon; // Menyimpan ikon
         $kategori->id_resto = Auth::user()->restoran->id;
         $kategori->save();
     
         return redirect()->back()->with('success', 'Data berhasil disimpan');
     }
     
     public function update(Request $request, $id)
     {
         $request->validate([
             'nama_kategori' => 'required|string|unique:kategori,nama_kategori,' . $id . ',id,id_resto,' . Auth::id(),
             'icon' => 'nullable|string',
         ]);
     
         $kategori = Kategori::find($id);
         $kategori->nama_kategori = $request->nama_kategori;
         $kategori->icon = $request->icon; // Memperbarui ikon
         $kategori->save();
     
         return redirect()->back()->with('success', 'Data berhasil diperbarui');
     }
     
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kategori = Kategori::find($id);

        return response()->json($kategori);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

   /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kategori = Kategori::find($id);
        $kategori->delete();

        return response(null, 204);
    }
}

 

