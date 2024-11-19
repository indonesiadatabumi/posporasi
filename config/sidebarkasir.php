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
		'icon' => 'fa fa-money-bill',
		'title' => 'Rekap Kasir',
		'url' => '/rekapkasir',
	],[
		
		'icon' => 'fa fa-sign-out',
			'title' => 'Logout',
			'url' => '/logout',
			'route-name' => 'logout'
	]]
];
