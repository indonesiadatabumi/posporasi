<?php
namespace App\Http\Controllers;
use App\Models\Kategori; // Ganti dengan nama model kategori Anda
use App\Models\Produk;   // Ganti dengan nama model produk Anda
use Illuminate\Http\Request;
use App\Models\Toko;


class MainController extends Controller {
    
    public function dashboard() {
        // Ambil jumlah kategori dan produk
        $jumlahKategori = Kategori::count();
        $jumlahProduk = Produk::count();
        $pengeluaran = 1291922; // Misalnya, Anda bisa mengubah ini untuk mengambil dari database
        $penjualan = 120; // Misalnya, Anda bisa mengubah ini untuk mengambil dari database

        // Kirim data ke view
        return view('dashboard', compact('jumlahKategori', 'jumlahProduk', 'pengeluaran', 'penjualan'));
    }
    
    public function laporanPenjualan() {
        return view('pages/laporan-penjualan');
    }
    public function laporanTransaksi() {
        return view('pages/laporan-transaksi');
    }
    public function laporanPengeluaran() {
        return view('pages/laporan-pengeluaran');
    }
    public function laporanPemasukan() {
        return view('pages/laporan-pemasukan');
    }
    
    public function posCustomerOrder() {
        return view('pages/pos-customer-order');
    }
    public function posKitchenOrder() {
        return view('pages/pos-kitchen-order');
    }
    public function posCounterCheckout() {
        return view('pages/pos-counter-checkout');
    }
    public function posTableBooking() {
        return view('pages/pos-table-booking');
    }
    public function posMenuStock() {
        return view('pages/pos-menu-stock');
    }
    
    public function emailTemplateSystem() {
        return view('pages/email-template-system');
    }
    public function emailTemplateNewsletter() {
        return view('pages/email-template-newsletter');
    }
    public function extraInvoice() {
        return view('pages/extra-invoice');
    }
    public function extraProfile() {
        return view('pages/extra-profile');
    }
    public function loginV1() {
        return view('pages/login-v1');
    }
    public function loginV2() {
        return view('pages/login-v2');
    }
    public function loginV3() {
        return view('pages/login-v3');
    }
    public function registerV3() {
        return view('pages/register-v3');
    }
    public function pengaturan() {
        return view('pages/pengaturan');
    }
    public function profil() {
        return view('pages/profil');
    }
    public function editProfil() {
        return view('pages/edit-profil');
    }
    public function menuDaftar() {
        
        return view('pages/menu-daftar');
    }
    

    
    // public function menuKategoriTambah() {
    //     return view('pages/menu-kategori-tambah');
    // }
    public function menuTambah() {
        return view('pages/menu-tambah');
    }
    
    // public function kategori() {
    //     return view('kategori/index');
    // }
}

// use App\Models\User;

// class UserController extends Controller
// {
//     public function register(Request $request)
//     {
//         // Validasi data
//         $validatedData = $request->validate([
//             'name' => 'required|string|max:255',
//             'identity_number' => 'required|string|max:255',
//             'address' => 'required|string|max:255',
//             'phone_number' => 'required|string|max:255',
//             'username' => 'required|string|max:255|unique:users',
//             'email' => 'required|string|email|max:255|unique:users',
//             'password' => 'required|string|min:8|confirmed',
//         ]);

//         // Buat pengguna baru
//         $user = User::create([
//             'name' => $validatedData['name'],
//             'identity_number' => $validatedData['identity_number'],
//             'address' => $validatedData['address'],
//             'phone_number' => $validatedData['phone_number'],
//             'username' => $validatedData['username'],
//             'email' => $validatedData['email'],
//             'password' => bcrypt($validatedData['password']), // Hash password
//         ]);

//         // Redirect atau beri respons sesuai kebutuhan
//         return redirect()->route('home')->with('success', 'Akun telah dibuat!');
//     }

//     // use App\Models\Menu; // Pastikan model Menu sudah di-import

// // public function showMenu()
// // {
// //     // Mengambil semua data menu dari database
// //     $menus = Menu::all();

// //     // Mengirim data menu ke tampilan
// //     return view('pages.menu-daftar', compact('menus'));
// // }
// }

