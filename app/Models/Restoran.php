<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restoran extends Model
{
    use HasFactory;
    protected $table = 'restoran';
    protected $fillable = [
        'nama_resto', 
        'nomor_identitas',
        'email', 
        'alamat', 
        'nomor_telepon'
    ];
    public function printer()
    {
        return $this->hasMany(Printer::class, 'id_resto');
    }
}
