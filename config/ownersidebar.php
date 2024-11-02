<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */
 'menu' => [[
		'icon' => 'fa fa-sitemap',
		'title' => 'Dashboard',
		'url' => 'javascript:;',
			'url' => '/dashboard',
			'title' => 'Dashboard',
			'route-name' => 'dashboard'
	],[
		'icon' => 'fa fa-utensils',
		'title' => 'POS System',
		'url' => '/pembelian',
	],[
	'icon' => 'fa fa-database',
		'title' => 'MASTER',
		'url' => 'javascript:;',
		'caret' => true,
		'sub_menu' => [[
			'url' => '/kategori',
			'title' => 'Kategori',
			'route-name' => 'index'
		],[
			'url' => '/produk',
			'title' => 'Produk',
			'route-name' => 'index'
		],[
			'url' => '/meja',
			'title' => 'Meja',
			'route-name' => 'index'
		]]

	],[
	'icon' => 'fa fa-money-bill',
		'title' => 'TRANSAKSI',
		'url' => 'javascript:;',
		'caret' => true,
		'sub_menu' => [[
			'url' => '/lpembayaran',
			'title' => 'Laporan Pembayaran',
			'route-name' => '/lpembayaran	'
		],[
			'url' => '/pembelian',
			'title' => 'Pembelian',
			'route-name' => '/pembelian'
		],[
			'url' => '/lpembelian',
			'title' => 'Laporan Penjualan',
			'route-name' => '/lpembelian'		
		]]
	
	],[
		'icon' => 'fa fa-file',
		'title' => 'REPORT',
		'url' => 'javascript:;',
		'caret' => true,
		'sub_menu' => [[
				'url' => '/laporan/transaksi',
				'title' => 'Transaksi',
				'route-name' => 'laporan-transaksi'
			],[
				'url' => '/laporan/pengeluaran',	
				'title' => 'Pengeluaran',
				'route-name' => 'laporan-pengeluaran'
			],[
				'url' => '/laporan/pemasukan',
				'title' => 'Pemasukan',
				'route-name' => 'laporan-pemasukan'
			
			]]		
	],[
		'icon' => 'fa fa-users',
			'title' => 'User',
			'url' => 'javascript:;',
			'route-name' => '/pengaturan'
	],[
		'icon' => 'fa fa-cog',
			'title' => 'Pengaturan',
			'url' => 'javascript:;',
			'route-name' => '/pengaturan'
	
	],[
	'icon' => 'fa fa-key',
'url' =>'logout',
'title' => 'Logout',
'route-name' => ''


	]]
];
