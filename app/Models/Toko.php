<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    use HasFactory;

    protected $table = 'toko';
    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function kategori() {
        return $this->hasMany(Kategori::class);
}

public function pembelian() {
    return $this->hasMany(Pembelian::class);
}

public function pembelianDetail() {
    return $this->hasMany(PembelianDetail::class);
}

public function produk() {
    return $this->hasMany(Produk::class);
}

public function supplier() {
    return $this->hasMany(Supplier::class);
}

public function pengeluaran() {
    return $this->hasMany(Pengeluaran::class);
}



public function pembayaran() {
    return $this->hasMany(Pembayaran::class);
}
}
