<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        $owner = Role::create(['name' => 'owner']);
        $kasir = Role::create(['name' => 'kasir']);
        $kitchen = Role::create(['name' => 'kitchen']);
        
        $admin = Role::create(['name' => 'admin']);  
        $permissions = [
            'access_all',
            'access_pembelian',
            'access_pembayaran',
            'access_kategori',
            'access_produk',
            'access_meja',
            'access_kitchen',
            'access_kitchenorder',
            'access_dashboard',
            'access_admin',  
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $owner->givePermissionTo($permissions);  
        $kasir->givePermissionTo(['access_pembelian', 'access_dashboard', 'access_pembayaran']);
        $kitchen->givePermissionTo(['access_kategori', 'access_dashboard', 'access_produk', 'access_meja', 'access_kitchen', 'access_kitchenorder']);

        $admin->givePermissionTo($permissions);
    }
}
