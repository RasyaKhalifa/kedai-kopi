<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PesananController;

// TEST ROUTE
Route::get('/', function () {
    return view('home');
});

// CUSTOMER ROUTES

// Scan QR → redirect ke menu meja
Route::get('/meja/{kode_qr}', [MenuController::class, 'scanQR'])->name('scan.qr');

// Halaman menu
Route::get('/menu/{meja_id}', [MenuController::class, 'index'])->name('menu.index');

// Keranjang (session-based)
Route::post('/keranjang/tambah', [PesananController::class, 'tambahKeranjang'])->name('keranjang.tambah');
Route::post('/keranjang/hapus', [PesananController::class, 'hapusKeranjang'])->name('keranjang.hapus');
Route::post('/keranjang/update', [PesananController::class, 'updateKeranjang'])->name('keranjang.update');
Route::get('/keranjang', [PesananController::class, 'keranjang'])->name('keranjang.index');

// Checkout & simpan pesanan
Route::get('/checkout/{meja_id}', [PesananController::class, 'checkout'])->name('checkout.index');
Route::post('/checkout/simpan', [PesananController::class, 'simpanPesanan'])->name('checkout.simpan');

// Tracking pesanan
Route::get('/tracking/{kode_pesanan}', [PesananController::class, 'tracking'])->name('tracking.index');