<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;   

class UsersSeeder extends Seeder
{
    public function run()
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        
        $restoranId = DB::table('restoran')->where('nama_resto', 'Restoran DBI')->value('id');

        $user = User::create([
            'nama' => 'Aby Ganteng',
            'id_resto' => $restoranId,
            'nomor_identitas' => '1234123456785678',  
            'email' => 'aby@dbi.com',
            'password' => Hash::make('password123'),  
            'role' => 'admin',  
            'alamat' => 'Jl. Raya No. 45, Jakarta',
            'nomor_telepon' => '082345678901',
        ]);

        $user->assignRole($adminRole);  

    }
}
