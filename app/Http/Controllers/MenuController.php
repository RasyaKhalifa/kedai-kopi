<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Kategori;
use App\Models\Meja; // Tambahkan import Model Meja di sini
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        // 1. Mengambil nomor meja dari query string (misal: ?meja=01)
        if ($request->has('meja')) {
            $nomorMeja = $request->meja;

            // 2. Cari data meja tersebut di database tabel 'mejas'
            $meja = Meja::where('nomor_meja', $nomorMeja)->first();

            if ($meja) {
                // 3. JIKA STATUS MEJA ADALAH "Terisi", BLOKIR AKSES & LEMPAR KE VIEW PENUH
                if ($meja->status_meja === 'Terisi') {
                    return response()->view('meja_penuh', compact('nomorMeja'), 403);
                }

                // 4. JIKA TERSEDIA, Simpan nomor meja ke session seperti biasa
                session(['nomor_meja' => $nomorMeja]);
            } else {
                return redirect('/')->with('error', 'Nomor meja tidak terdaftar.');
            }
        }

        // Tampilkan menu jika lolos pengecekan atau akses tanpa QR (?meja=)
        $kategoris = Kategori::with('menus')->get();
        $menus = Menu::where('status_stok', 'Tersedia')->get();

        return view('home', compact('kategoris', 'menus'));
    }
}