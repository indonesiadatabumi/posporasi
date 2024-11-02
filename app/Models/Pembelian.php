<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;
    protected $table = 'pembelian';
    protected $fillable = [
        'pembeli', 
        'jenis_pesanan', 
        'total_harga', 
        'pajak', 
        'status'];

        public function detail()
        {
            return $this->hasMany(PembelianDetail::class, 'id_pembelian');
        }

        public function user() {
            return $this->belongsTo(User::class);
        }

        public function meja()
        {
            return $this->belongsTo(Meja::class, 'id_meja'); // Sesuaikan dengan nama kolom yang Anda miliki
        }
        public function pembayaran()
        {
            return $this->hasOne(Pembayaran::class, 'pembelian_id');
        }

}