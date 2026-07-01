<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Meja;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PesananController extends Controller
{
    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    public function addToCart($id)
    {
        $menu = Menu::findOrFail($id);
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['jumlah']++;
        } else {
            $cart[$id] = [
                "nama_menu" => $menu->nama_menu,
                "jumlah" => 1,
                "harga" => $menu->harga,
                "foto" => $menu->foto
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Menu berhasil dimasukkan ke keranjang!');
    }

    public function updateCart(Request $request)
    {
        if($request->id && $request->jumlah){
            $cart = session()->get('cart', []);
            $cart[$request->id]["jumlah"] = $request->jumlah;
            session()->put('cart', $cart);
        }
    }

    public function removeFromCart(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart', []);
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
        }
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        if(empty($cart)) {
            return redirect()->route('menu.index')->with('error', 'Keranjang Anda kosong!');
        }
        return view('checkout', compact('cart'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'nomor_meja' => 'required'
        ]);

        $cart = session()->get('cart', []);
        if(empty($cart)) {
            return redirect()->route('menu.index')->with('error', 'Keranjang kosong!');
        }

        $meja = Meja::where('nomor_meja', $request->nomor_meja)->first();
        if (!$meja) {
            return redirect()->back()->with('error', 'Nomor meja tidak valid!');
        }

        // 1. Simpan Data Pelanggan (Menyertakan no_hp bernilai default '-')
        $pelanggan = Pelanggan::create([
            'nama'  => $request->nama_pelanggan,
            'no_hp' => '-'
        ]);

        $total = 0;
        foreach($cart as $item) {
            $total += $item['harga'] * $item['jumlah'];
        }

        // 2. Simpan ke tabel induk pesanans
        $pesanan = Pesanan::create([
            'meja_id'           => $meja->id,
            'pelanggan_id'       => $pelanggan->id,
            'admin_id'          => null,
            'tanggal_pesanan'   => Carbon::now(),
            'total_harga'       => $total,
            'status_pesanan'    => 'Pending',
            'status_pembayaran' => 'Belum Bayar',
            'metode_pembayaran' => null
        ]);

        // 3. Looping untuk simpan ke tabel detail_pesanans (Menerima kolom harga)
        foreach($cart as $id => $details) {
            DetailPesanan::create([
                'pesanan_id' => $pesanan->id,
                'menu_id'    => $id,
                'jumlah'     => $details['jumlah'],
                'harga'      => $details['harga'],
                'subtotal'   => $details['harga'] * $details['jumlah']
            ]);
        }

        // 4. Update status meja menjadi 'Terisi'
        $meja->update(['status_meja' => 'Terisi']);

        session()->forget('cart');

        return redirect()->route('tracking', ['id' => $pesanan->id])->with('success', 'Pesanan sukses dibuat!');
    }

    public function tracking($id)
    {
        $pesanan = Pesanan::with(['detailPesanan.menu', 'pelanggan', 'meja'])->findOrFail($id);
        return view('tracking', compact('pesanan'));
    }
}