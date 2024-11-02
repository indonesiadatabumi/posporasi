<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $fillable = [
        'pembelian_id', 
        'subtotal', 
        'total_pembayaran', 
        'pajak', 
        'metode_pembayaran', 
        'status'];

    public function pembelian()
    {
        return $this->hasMany(PembelianDetail::class);

    }
    public function detail()
    {
        return $this->hasMany(PembelianDetail::class);
    }

    public function meja()
    {
        return $this->belongsTo(Meja::class, 'id_meja');
    }
    
    public function user() {
        return $this->belongsTo(User::class);
    }
    
}
