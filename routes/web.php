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
use App\Http\Controllers\RestoController;
use App\Http\Controllers\MUserController;
use App\Http\Controllers\RekapKasirController;
use App\Http\Controllers\KitchenOrderController;
use App\Http\Controllers\RestoranController;
use App\Http\Controllers\LiatUserController;
use App\Http\Controllers\PrinterController;

Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return redirect('/dashboard');
    });

    Route::get('/dashboard', [MainController::class, 'dashboard'])->name('dashboard')->middleware('permission:access_dashboard');
    Route::get('/dashboard/monthly-income', [MainController::class, 'getMonthlyIncomeData']);
    Route::get('/dashboard/daily-income', [MainController::class, 'getDailyIncome']);


    Route::middleware('permission:access_kategori')->group(function () {
        Route::get('/kategori/data', [KategoriController::class, 'data'])->name('kategori.data');
        Route::resource('/kategori', KategoriController::class);
    });

    // Meja Routes
    Route::middleware('permission:access_meja')->group(function () {
        Route::get('/meja/data', [MejaController::class, 'data'])->name('meja.data');
        Route::resource('/meja', MejaController::class);
    });

    // Produk Routes
    Route::middleware('permission:access_produk')->group(function () {
        Route::get('/produk/data', [ProdukController::class, 'data'])->name('produk.data');
        Route::post('/produk/delete-selected', [ProdukController::class, 'deleteSelected'])->name('produk.delete_selected');
        Route::resource('/produk', ProdukController::class);
        
	Route::put('/produk/{id}/adjust-stock', [ProdukController::class, 'adjustStock'])->name('produk.adjustStock');

    });

    // Supplier Routes
    Route::middleware('permission:access_all')->group(function () {
        Route::get('/supplier/data', [SupplierController::class, 'data'])->name('supplier.data');
        Route::resource('/supplier', SupplierController::class);
    });

    // Pengeluaran Routes
    Route::middleware('permission:access_all')->group(function () {
        Route::get('/pengeluaran/data', [PengeluaranController::class, 'data'])->name('pengeluaran.data');
        Route::resource('/pengeluaran', PengeluaranController::class);
    });

    Route::middleware('permission:access_pembelian')->group(function () {
        Route::get('/pembelian', [PembelianController::class, 'index'])->name('pembelian.index');
        Route::post('/pembelian/store', [PembelianController::class, 'store'])->name('pembelian.store');
        Route::post('/pembelian/checkout', [PembelianController::class, 'checkout']);
        Route::get('/pembelian/{id}/edit', [PembelianController::class, 'edit'])->name('pembelian.edit');
        Route::put('/pembelian/{id}', [PembelianController::class, 'update'])->name('pembelian.update');
        Route::delete('/pembelian/{id}', [PembelianController::class, 'destroy'])->name('pembelian.destroy');
        Route::get('/rekapkasir', [RekapKasirController::class, 'index'])->name('rekapkasir.index');
        Route::get('/rekapkasir/data', [RekapKasirController::class, 'data'])->name('rekapkasir.data');
        Route::get('/rekapkasir/export-pdf', [RekapKasirController::class, 'exportPDF'])->name('rekapkasir.exportPDF');

        Route::resource('printer', PrinterController::class);
        Route::delete('/{printer}', [PrinterController::class, 'destroy'])->name('destroy');
        Route::get('/setDefault/{printer}', [PrinterController::class, 'setDefault'])->name('setDefault');   
        Route::post('/printer/setDefault/{printer}', [PrinterController::class, 'setDefault'])->name('printer.setDefault');
        
    });


    Route::middleware('permission:access_pembayaran')->group(function () {
        Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
        Route::get('/pembayaran/ambil/{id}', [PembayaranController::class, 'ambilPembelian']);
        Route::post('/pembayaran', [PembayaranController::class, 'bayar']);
        Route::delete('/pembelian/{id}', [PembayaranController::class, 'destroy'])->name('pembelian.destroy');
        Route::get('/pembayaran/{id}', [PembayaranController::class, 'show']);
        Route::get('/pembayaran/print-receipt/{id}', [PembayaranController::class, 'printReceipt'])->name('print.receipt');
        Route::get('/lpembayaran/export_pdf', [LPembayaranController::class, 'cetakPdf'])->name('lpembayaran.export_pdf');
        Route::get('/pembayaran/{id}/print-pdf', [PembayaranController::class, 'printPDF'])->name('pembayaran.print-pdf');

    });


    
    Route::middleware('permission:access_kitchen')->group(function () {
        Route::get('/kitchen', [KitchenController::class, 'index'])->name('kitchen.index');
    });

    // Kitchen Order Routes
    Route::middleware('permission:access_kitchenorder')->group(function () {
        Route::get('/kitchenorder', [KitchenOrderController::class, 'index'])->name('kitchenorder.index');
        Route::post('/kitchenorder/update-status/{id}', [KitchenOrderController::class, 'completeItem']);
    });

    // Laporan Pembayaran Routes
    Route::middleware('permission:access_all')->group(function () {
        Route::get('/lpembayaran/data', [LPembayaranController::class, 'data'])->name('lpembayaran.data');
        Route::resource('/lpembayaran', LPembayaranController::class);
    });

    // Pemasukan Routes
    Route::middleware('permission:access_all')->group(function () {
        Route::get('/pemasukan/data', [PemasukanController::class, 'data'])->name('pemasukan.data');
        Route::get('/pemasukan', [PemasukanController::class, 'index']);
        Route::get('/pemasukan/export-pdf', [PemasukanController::class, 'exportPdf'])->name('pemasukan.export_pdf');
    });

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    // Resto Routes
    Route::get('/resto', [RestoController::class, 'index'])->name('resto.index');
    Route::put('/resto', [RestoController::class, 'update'])->name('resto.update');
    
    
    Route::middleware('role:admin')->group(function () {
        Route::get('/restoran', [RestoranController::class, 'index']);
        Route::get('/restoran/data', [RestoranController::class, 'data'])->name('restoran.data');
Route::delete('/restoran/{id}', [RestoranController::class, 'destroy'])->name('restoran.destroy');        
    Route::get('/liatuser', [LiatUserController::class, 'index']);
    Route::get('/liatuser/data', [LiatUserController::class, 'data'])->name('users.data');
});

    Route::middleware('permission:access_all')->group(function () {
        Route::get('/users', [MUserController::class, 'data'])->name('users.data');
        Route::resource('users', MUserController::class);
    });
    Route::middleware('permission:access_all')->group(function () {
        Route::get('/lpenjualan', [LPenjualanController::class, 'index'])->name('lpenjualan.index');
        Route::get('/lpenjualan/data', [LPenjualanController::class, 'data'])->name('lpenjualan.data');
        Route::post('/lpenjualan/store', [LPenjualanController::class, 'store'])->name('lpenjualan.store');
        Route::get('/lpenjualan/export_pdf', [LPenjualanController::class, 'cetakPdf'])->name('lpenjualan.export_pdf'); // Route untuk export PDF

    });
});

// Authentication Routes
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

// Guest Routes
Route::middleware(['guest'])->group(function () {
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

