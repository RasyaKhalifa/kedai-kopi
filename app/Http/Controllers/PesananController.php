<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{Menu, Pesanan, DetailPesanan};
use Illuminate\Support\Str;

class PesananController extends Controller
{
    // ─── KERANJANG ────────────────────────────────────────────────────────────
    public function tambahKeranjang(Request $request)
    {
        $request->validate(['menu_id' => 'required|exists:menus,id']);
        $menu = Menu::findOrFail($request->menu_id);
        $keranjang = session('keranjang', []);
        $key = 'menu_' . $menu->id;

        $keranjang[$key] = [
            'menu_id' => $menu->id,
            'nama_menu' => $menu->nama_menu,
            'harga' => $menu->harga,
            'qty' => ($keranjang[$key]['qty'] ?? 0) + 1
        ];

        session(['keranjang' => $keranjang]);
        return back()->with('success', 'Ditambahkan ke keranjang!');
    }

    // ─── CHECKOUT ─────────────────────────────────────────────────────────────
    public function simpanPesanan(Request $request)
    {
        $request->validate(['nama_pelanggan' => 'required|string|max:100']);
        $keranjang = session('keranjang', []);
        
        if (empty($keranjang)) return back()->with('error', 'Keranjang kosong!');

        DB::beginTransaction();
        try {
            $kode = 'KDK-' . strtoupper(Str::random(6));
            $total = collect($keranjang)->sum(fn($i) => $i['harga'] * $i['qty']);

            $pesanan = Pesanan::create([
                'kode_pesanan'   => $kode,
                'meja_id'        => session('meja_id'),
                'nama_pelanggan' => $request->nama_pelanggan,
                'total_harga'    => $total,
                'status'         => 'pending',
            ]);

            foreach ($keranjang as $item) {
                DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'menu_id'    => $item['menu_id'],
                    'qty'        => $item['qty'],
                    'harga'      => $item['harga'],
                    'subtotal'   => $item['harga'] * $item['qty'],
                ]);
            }

            DB::commit();
            session()->forget(['keranjang', 'meja_id', 'nomor_meja']);
            return redirect()->route('tracking.index', $kode)->with('success', 'Pesanan sukses!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses pesanan.');
        }
    }

    // ─── TRACKING ─────────────────────────────────────────────────────────────
    public function tracking($kode)
    {
        $pesanan = Pesanan::with('detailPesanans.menu')
                          ->where('kode_pesanan', $kode)
                          ->firstOrFail();
        return view('tracking', compact('pesanan'));
    }
}