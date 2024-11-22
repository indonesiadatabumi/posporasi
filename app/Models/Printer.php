<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Printer extends Model
{
    use HasFactory;

    protected $table = 'printer';
    protected $guarded = ['id'];

    /**
     * Relasi ke model Restoran
     */
    public function restoran()
    {
        return $this->belongsTo(Restoran::class, 'id_resto');
    }
}
