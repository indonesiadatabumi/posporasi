<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 
        'id_resto', 
        'nomor_identitas', 
        'email', 
        'password', 
        'role', 
        'alamat', 
        'nomor_telepon'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function kategori() {
        return $this->hasMany(Kategori::class);
}

public function restoran()
{
    return $this->belongsTo(Restoran::class, 'id_resto');
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
public function meja() {
    return $this->hasMany(Meja::class);
}
}