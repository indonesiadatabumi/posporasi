<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PembelianDetailController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\LPembayaranController;
use App\Http\Controllers\LPembelianController;
use App\Http\Controllers\LPenjualanController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MUserController;
use App\Http\Controllers\KitchenOrderController;


Route::middleware(['auth'])->group(function () {

	Route::get('/', function () {
		return redirect('/dashboard');
	});

	
	Route::get('/dashboard', [MainController::class, 'dashboard'])->name('dashboard');

	Route::get('/kategori/data', [KategoriController::class, 'data'])->name('kategori.data');
	Route::resource('/kategori' , KategoriController::class);

	Route::get('/meja/data', [MejaController::class, 'data'])->name('meja.data');
	Route::resource('/meja' , MejaController::class);


	Route::get('/produk/data', [ProdukController::class, 'data'])->name('produk.data');
	Route::post('/produk/delete-selected', [ProdukController::class, 'deleteSelected'])->name('produk.delete_selected');
	Route::resource('/produk', ProdukController::class);

	Route::get('/supplier/data', [SupplierController::class, 'data'])->name('supplier.data');
	Route::resource('/supplier', SupplierController::class);

	Route::get('/pengeluaran/data', [PengeluaranController::class, 'data'])->name('pengeluaran.data');
	Route::resource('/pengeluaran', PengeluaranController::class);


	// Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');

	
	Route::get('/pembelian', [PembelianController::class, 'index'])->name('pembelian.index');
	Route::post('/pembelian/store', [PembelianController::class, 'store'])->name('pembelian.store');
	Route::post('/pembelian/checkout', [PembelianController::class, 'checkout']);
	// Route::get('/pembelian/{id}', [PembelianController::class, 'edit'])->name('pembelian.edit');
	Route::get('/pembelian/{id}/edit', [PembelianController::class, 'edit'])->name('pembelian.edit');
	Route::put('/pembelian/{id}', [PembelianController::class, 'update'])->name('pembelian.update');

    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::get('/pembayaran/ambil/{id}', [PembayaranController::class, 'ambilPembelian']);


	Route::get('/kitchen', [KitchenController::class, 'index'])->name('kitchen.index');
	Route::get('/kitchenorder', [KitchenOrderController::class, 'index'])->name('kitchenorder.index');
	Route::post('/kitchenorder/update-status/{id}', [KitchenOrderController::class, 'completeItem']);




	Route::put('/produk/{id}/adjust-stock', [ProdukController::class, 'adjustStock'])->name('produk.adjustStock');
	
	Route::delete('/pembelian/{id}', [PembayaranController::class, 'destroy'])->name('pembelian.destroy');
	Route::post('/pembayaran', [PembayaranController::class, 'bayar']);
	
	Route::get('/pembayaran/{id}', [PembayaranController::class, 'show']);


	Route::get('/lpembayaran/data', [LPembayaranController::class, 'data'])->name('lpembayaran.data');
	Route::resource('/lpembayaran', LPembayaranController::class);

	Route::get('/pemasukan/data', [PemasukanController::class, 'data'])->name('pemasukan.data');
	Route::get('/pemasukan', [PemasukanController::class, 'index']);

	Route::get('/pembayaran/print-receipt/{id}', [PembayaranController::class, 'printReceipt'])->name('print.receipt');


	Route::get('/lpenjualan', [LPenjualanController::class, 'index'])->name('lpenjualan.index');
	Route::get('/lpenjualan/data', [LPenjualanController::class, 'data'])->name('lpenjualan.data');
	Route::post('/lpenjualan/store', [LPenjualanController::class, 'store'])->name('lpenjualan.store');
	

	Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

	Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
	Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');


Route::get('/users', [MUserController::class, 'index'])->name('users.index');
Route::resource('users', MUserController::class);

});




Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware(['guest'])->group(function () {
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});
