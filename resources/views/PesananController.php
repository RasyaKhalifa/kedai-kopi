<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Meja;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Support\Str;

class PesananController extends Controller
{
    // ─── KERANJANG ────────────────────────────────────────────────────────────

    /**
     * Tambah item ke keranjang (session)
     */
    public function tambahKeranjang(Request $request)
    {
        $request->validate([
            'menu_id'  => 'required|exists:menus,id',
            'meja_id'  => 'required|exists:mejas,id',
            'catatan'  => 'nullable|string|max:200',
        ]);

        $menu      = Menu::findOrFail($request->menu_id);
        $keranjang = session('keranjang', []);
        $key       = 'menu_' . $menu->id;

        if (isset($keranjang[$key])) {
            $keranjang[$key]['qty']++;
        } else {
            $keranjang[$key] = [
                'menu_id'    => $menu->id,
                'nama_menu'  => $menu->nama_menu,
                'harga'      => $menu->harga,
                'foto'       => $menu->foto,
                'catatan'    => $request->catatan ?? '',
                'qty'        => 1,
            ];
        }

        session(['keranjang' => $keranjang, 'meja_id' => $request->meja_id]);

        return response()->json([
            'success' => true,
            'message' => $menu->nama_menu . ' ditambahkan ke keranjang!',
            'total'   => collect($keranjang)->sum('qty'),
        ]);
    }

    /**
     * Update qty item di keranjang
     */
    public function updateKeranjang(Request $request)
    {
        $request->validate([
            'menu_id' => 'required',
            'qty'     => 'required|integer|min:0',
        ]);

        $keranjang = session('keranjang', []);
        $key       = 'menu_' . $request->menu_id;

        if ($request->qty == 0) {
            unset($keranjang[$key]);
        } elseif (isset($keranjang[$key])) {
            $keranjang[$key]['qty'] = $request->qty;
        }

        session(['keranjang' => $keranjang]);

        $subtotal = collect($keranjang)->sum(fn($i) => $i['harga'] * $i['qty']);

        return response()->json([
            'success'  => true,
            'total'    => collect($keranjang)->sum('qty'),
            'subtotal' => $subtotal,
        ]);
    }

    /**
     * Hapus satu item dari keranjang
     */
    public function hapusKeranjang(Request $request)
    {
        $keranjang = session('keranjang', []);
        $key       = 'menu_' . $request->menu_id;
        unset($keranjang[$key]);
        session(['keranjang' => $keranjang]);

        return response()->json(['success' => true, 'total' => collect($keranjang)->sum('qty')]);
    }

    /**
     * Tampilkan halaman keranjang (inline di menu — dipakai modal)
     */
    public function keranjang()
    {
        $keranjang = session('keranjang', []);
        $meja_id   = session('meja_id');
        $meja      = $meja_id ? Meja::find($meja_id) : null;

        return view('keranjang', compact('keranjang', 'meja'));
    }

    // ─── CHECKOUT ─────────────────────────────────────────────────────────────

    /**
     * Halaman checkout
     */
    public function checkout($meja_id)
    {
        $meja      = Meja::findOrFail($meja_id);
        $keranjang = session('keranjang', []);

        if (empty($keranjang)) {
            return redirect()->route('menu.index', $meja_id)
                             ->with('error', 'Keranjang masih kosong!');
        }

        $subtotal = collect($keranjang)->sum(fn($i) => $i['harga'] * $i['qty']);

        return view('checkout', compact('meja', 'keranjang', 'subtotal'));
    }

    /**
     * Simpan pesanan ke database
     */
    public function simpanPesanan(Request $request)
    {
        $request->validate([
            'meja_id'       => 'required|exists:mejas,id',
            'nama_pelanggan'=> 'required|string|max:100',
            'catatan_umum'  => 'nullable|string|max:500',
        ]);

        $keranjang = session('keranjang', []);

        if (empty($keranjang)) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }

        $kode   = 'KDK-' . strtoupper(Str::random(8));
        $total  = collect($keranjang)->sum(fn($i) => $i['harga'] * $i['qty']);

        // Buat pesanan
        $pesanan = Pesanan::create([
            'kode_pesanan'   => $kode,
            'meja_id'        => $request->meja_id,
            'nama_pelanggan' => $request->nama_pelanggan,
            'catatan_umum'   => $request->catatan_umum,
            'total_harga'    => $total,
            'status'         => 'pending',
        ]);

        // Buat detail pesanan
        foreach ($keranjang as $item) {
            DetailPesanan::create([
                'pesanan_id' => $pesanan->id,
                'menu_id'    => $item['menu_id'],
                'qty'        => $item['qty'],
                'harga'      => $item['harga'],
                'catatan'    => $item['catatan'] ?? '',
                'subtotal'   => $item['harga'] * $item['qty'],
            ]);
        }

        // Kosongkan keranjang session
        session()->forget(['keranjang', 'meja_id', 'nomor_meja']);

        return redirect()->route('tracking.index', $kode)
                         ->with('success', 'Pesanan berhasil dikirim! Kode: ' . $kode);
    }

    // ─── TRACKING ─────────────────────────────────────────────────────────────

    /**
     * Halaman tracking status pesanan
     */
    public function tracking($kode_pesanan)
    {
        $pesanan = Pesanan::with(['detailPesanans.menu', 'meja'])
                          ->where('kode_pesanan', $kode_pesanan)
                          ->firstOrFail();

        return view('tracking', compact('pesanan'));
    }
}
