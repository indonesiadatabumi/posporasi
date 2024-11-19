<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RestoranSeeder extends Seeder
{
    public function run()
    {
        DB::table('restoran')->insert([
            'nama_resto' => 'Restoran DBI',
            'nomor_identitas' => '00121234567890',  
            'email' => 'resto@dbi.com',
            'alamat' => 'Jl. Kebon Jeruk No. 123, Jakarta',
            'nomor_telepon' => '081234567890',
        ]);
    }
}
