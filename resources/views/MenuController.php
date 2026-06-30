<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Meja;
use App\Models\Kategori;

class MenuController extends Controller
{
    /**
     * Scan QR Code meja → redirect ke halaman menu
     */
    public function scanQR($kode_qr)
    {
        $meja = Meja::where('kode_qr', $kode_qr)
                    ->where('status', 'tersedia')
                    ->firstOrFail();

        // Simpan meja_id di session
        session(['meja_id' => $meja->id, 'nomor_meja' => $meja->nomor_meja]);

        return redirect()->route('menu.index', $meja->id);
    }

    /**
     * Tampilkan halaman menu berdasarkan meja
     */
    public function index($meja_id)
    {
        $meja = Meja::findOrFail($meja_id);

        // Ambil semua kategori dengan menu-nya (yang tersedia)
        $kategoris = Kategori::with(['menus' => function ($q) {
            $q->where('status', 'tersedia')->orderBy('nama_menu');
        }])->get();

        // Keranjang dari session
        $keranjang = session('keranjang', []);
        $totalKeranjang = collect($keranjang)->sum(fn($item) => $item['qty']);

        return view('menu', compact('meja', 'kategoris', 'keranjang', 'totalKeranjang'));
    }
}
