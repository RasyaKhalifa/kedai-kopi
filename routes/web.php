<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\DapurController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\MejaController as AdminMejaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| SISI PELANGGAN (CUSTOMER)
|--------------------------------------------------------------------------
*/

// Menu Utama Sisi Pelanggan (Menangkap parameter ?meja=XX)
Route::get('/', [MenuController::class, 'index'])->name('menu.index');

// Halaman Proteksi jika pelanggan scan meja yang statusnya 'Terisi'
Route::view('/meja-penuh', 'customer.meja_penuh')->name('customer.meja_penuh');

// Keranjang / Cart Belanja Pelanggan
Route::get('/cart', [PesananController::class, 'cart'])->name('cart.index');
Route::get('/add-to-cart/{id}', [PesananController::class, 'addToCart'])->name('cart.add');
Route::patch('/update-cart', [PesananController::class, 'updateCart'])->name('cart.update');
Route::delete('/remove-from-cart', [PesananController::class, 'removeFromCart'])->name('cart.remove');

// Checkout & Penyimpanan Pesanan Pelanggan
Route::get('/checkout', [PesananController::class, 'checkout'])->name('checkout');
Route::post('/pesanan', [PesananController::class, 'store'])->name('pesanan.store');

// Status Tracking Pesanan Pelanggan
Route::get('/tracking/{id}', [PesananController::class, 'tracking'])->name('tracking');


/*
|--------------------------------------------------------------------------
| SISI BACKOFFICE (ADMIN, KASIR, & DAPUR)
|--------------------------------------------------------------------------
*/

// Login Admin & Staff (Tidak membutuhkan Middleware Sesi)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'formLogin'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login.proses');
});

// Proteksi Middleware: Hanya Staff/Admin yang sudah login bisa masuk ke rute di bawah ini
Route::middleware('admin.auth')->group(function () {

    // ==================== 1. ADMIN PANEL ====================
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // CRUD Kelola Menu Makanan & Minuman
        Route::resource('menu', AdminMenuController::class)->names('menu')->except(['show']);
        
        // CRUD Kelola Meja Makan
        Route::resource('meja', AdminMejaController::class)->names('meja')->except(['show']);
        
        // Rute Khusus untuk Menampilkan & Mencetak QR Code Meja
        Route::get('/meja/{meja}/qrcode', [AdminMejaController::class, 'qrcode'])->name('meja.qrcode');
    });

    // ==================== 2. KASIR PANEL ====================
    Route::prefix('kasir')->name('kasir.')->group(function () {
        Route::get('/', [KasirController::class, 'index'])->name('index');
        Route::patch('/pesanan/{pesanan}/status', [KasirController::class, 'updateStatus'])->name('status.update');
        Route::get('/pesanan/{pesanan}/bayar', [KasirController::class, 'formBayar'])->name('bayar.form');
        Route::post('/pesanan/{pesanan}/bayar', [KasirController::class, 'prosesBayar'])->name('bayar.proses');
        Route::get('/pesanan/{pesanan}/struk', [KasirController::class, 'struk'])->name('struk');
        Route::get('/laporan', [KasirController::class, 'laporan'])->name('laporan');
    });

    // ==================== 3. DAPUR PANEL ====================
    Route::prefix('dapur')->name('dapur.')->group(function () {
        Route::get('/', [DapurController::class, 'index'])->name('index');
        Route::patch('/pesanan/{pesanan}/mulai', [DapurController::class, 'mulaiMasak'])->name('mulai');
        Route::patch('/pesanan/{pesanan}/selesai', [DapurController::class, 'selesaiMasak'])->name('selesai');
    });
});