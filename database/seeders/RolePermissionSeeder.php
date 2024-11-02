<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Membuat peran
        $superAdmin = Role::create(['name' => 'super_admin']);
        $owner = Role::create(['name' => 'owner']);
        $pegawai = Role::create(['name' => 'pegawai']);
        
        // Membuat izin
        Permission::create(['name' => 'manage stores']);
        Permission::create(['name' => 'manage employees']);
        
        // Menyusun izin ke peran
        $superAdmin->givePermissionTo(['manage stores', 'manage employees']);
        $owner->givePermissionTo('manage stores');
    }
}
