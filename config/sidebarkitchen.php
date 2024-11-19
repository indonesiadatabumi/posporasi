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
		'url' => '/kitchenorder',
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
		'icon' => 'fa fa-sign-out',
			'title' => 'Logout',
			'url' => '/logout',
			'route-name' => 'logout'
	]]
];
