<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\Produk;
use PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Ambil kategori berdasarkan id dari restoran pengguna yang sedang login
        $kategori = Kategori::where('id_resto', Auth::user()->restoran->id)->pluck('nama_kategori', 'id');
        
        return view('produk.index', compact('kategori'));
    }
    
    public function data()
    {
        $produk = Produk::leftJoin('kategori', 'kategori.id', 'produk.id_kategori')
            ->where('produk.id_resto', Auth::user()->restoran->id)  
            ->select('produk.*', 'nama_kategori')
            ->orderBy('kode_produk', 'asc')
            ->get();
    
        return datatables()
            ->of($produk)
            ->addIndexColumn()
            ->addColumn('select_all', function ($produk) {
                return '<input type="checkbox" name="id_produk[]" value="'. $produk->id_produk .'">';
            })
            ->addColumn('foto', function ($produk) {
                $path = asset('storage/' . $produk->foto);
                return '<img src="'. $path .'" alt="'. $produk->nama_produk .'" class="img-thumbnail" style="width: 100px;">';
            })
            ->addColumn('kode_produk', function ($produk) {
                return '<span class="label label-success">'. $produk->kode_produk .'</span>';
            })
            ->addColumn('harga_beli', function ($produk) {
                return format_uang($produk->harga_beli);
            })
            ->addColumn('harga_jual', function ($produk) {
                return format_uang($produk->harga_jual);
            })
            ->addColumn('stok', function ($produk) {
                return format_uang($produk->stok);
            })
            ->addColumn('aksi', function ($produk) {
                return 
                '<div class="btn-group">
                    <button type="button" onclick="editForm(`'. route('produk.update', $produk->id) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button type="button" onclick="deleteData(`'. route('produk.destroy', $produk->id) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>';
            })
            ->rawColumns(['aksi', 'kode_produk', 'select_all', 'foto'])
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
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama_produk' => [
                'required',
                'string',
                'max:255',
                Rule::unique('produk')->where(function ($query) {
                    return $query->where('id_resto', Auth::user()->restoran->id);
                }),
            ],
            'deskripsi' => 'required',
            'id_kategori' => 'required',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer',
            'stok' => 'required|integer',
        ]);
    
        try {
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads/produk', $fileName, 'public');
            }
    
            $kode_produk = $this->generateKodeProduk();
    
            Produk::create(array_merge($request->all(), [
                'kode_produk' => $kode_produk,
                'foto' => $filePath ?? null,  
                'id_resto' => Auth::user()->restoran->id,
            ]));
    
            return redirect()->back()->with('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    private function generateKodeProduk()
    {
        $lastProduct = Produk::where('id_resto', Auth::user()->restoran->id)
            ->orderBy('kode_produk', 'desc')
            ->first();
        
        if (!$lastProduct) {
            return 'P000001';
        }
        
        $lastKode = substr($lastProduct->kode_produk, 1);
        $newKode = (int)$lastKode + 1;
        
        return 'P' . str_pad($newKode, 6, '0', STR_PAD_LEFT);
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produk = Produk::find($id);

        return response()->json($produk);
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
    public function update(Request $request, $id)
    {
        $produk = Produk::find($id);
        
        $request->validate([
            'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama_produk' => [
                'required',
                'string',
                'max:255',
                Rule::unique('produk')->where(function ($query) use ($id) {
                    return $query->where('id_resto', Auth::id())->where('id', '<>', $id);
                }),
            ],
            'deskripsi' => 'required',
            'id_kategori' => 'required',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer',
            'stok' => 'required|integer',
        ]);
        
        if ($request->hasFile('foto')) {
            if ($produk->foto && \Storage::disk('public')->exists($produk->foto)) {
                \Storage::disk('public')->delete($produk->foto);
            }

            $file = $request->file('foto');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/produk', $fileName, 'public');
        } else {
            $filePath = $produk->foto;
        }
        
        $produk->update(array_merge($request->all(), [
            'foto' => $filePath, 
        ]));

        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produk = Produk::find($id);
        $produk->delete();

        return response(null, 204);
    }

    public function adjustStock(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);
        $request->validate([
            'stok' => 'required|integer|min:0',
        ]);
    
        $produk->stok = $request->stok;  
        $produk->save();  
    
        return redirect()->back()->with('success', 'Stok produk berhasil diperbarui.');
    }
}
