<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kategori')->insert([
            ['nama_kategori' => 'Minunman', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Snack', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Mie', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
