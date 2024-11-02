<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    use HasFactory;

    protected $table = 'pembelian_detail'; 
    protected $fillable = [
        'id_pembelian',
        'id_produk',
        'jumlah',
        'harga_satuan',
        'total_harga'
    ];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'id_pembelian');
    }

    public function produk() {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
