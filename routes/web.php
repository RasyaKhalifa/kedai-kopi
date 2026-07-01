<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\PesananController;
use Illuminate\Support\Facades\Route;

// Menu Sisi Pelanggan
Route::get('/', [MenuController::class, 'index'])->name('menu.index');

// Keranjang / Cart Belanja
Route::get('/cart', [PesananController::class, 'cart'])->name('cart.index');
Route::get('/add-to-cart/{id}', [PesananController::class, 'addToCart'])->name('cart.add');
Route::patch('/update-cart', [PesananController::class, 'updateCart'])->name('cart.update');
Route::delete('/remove-from-cart', [PesananController::class, 'removeFromCart'])->name('cart.remove');

// Checkout & Penyimpanan Pesanan
Route::get('/checkout', [PesananController::class, 'checkout'])->name('checkout');
Route::post('/pesanan', [PesananController::class, 'store'])->name('pesanan.store');

// Status Tracking Pesanan Pelanggan
Route::get('/tracking/{id}', [PesananController::class, 'tracking'])->name('tracking');