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
    // 1. Menampilkan halaman Keranjang Belanja
    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    // 2. Menambah item menu ke dalam keranjang (Session)
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
        return redirect()->back()->with('success', 'Menu berhasil ditambahkan ke keranjang!');
    }

    // 3. Mengubah jumlah item di dalam keranjang lewat AJAX
    public function updateCart(Request $request)
    {
        if($request->id && $request->jumlah){
            $cart = session()->get('cart', []);
            $cart[$request->id]["jumlah"] = $request->jumlah;
            session()->put('cart', $cart);
            session()->flash('success', 'Keranjang berhasil diperbarui');
        }
    }

    // 4. Menghapus item dari keranjang lewat AJAX
    public function removeFromCart(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart', []);
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Menu dihapus dari keranjang');
        }
    }

    // 5. Halaman checkout / konfirmasi data pelanggan sebelum memesan
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if(empty($cart)) {
            return redirect()->route('menu.index')->with('error', 'Keranjang Anda kosong!');
        }
        return view('checkout', compact('cart'));
    }

    // 6. MENYIMPAN PESANAN SESUAI DB RELESIAL KHIRPEN
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

        // Cari meja_id berdasarkan nomor_meja yang di-scan (Contoh: 'M01')
        $meja = Meja::where('nomor_meja', $request->nomor_meja)->first();
        if (!$meja) {
            return redirect()->back()->with('error', 'Nomor meja tidak valid!');
        }

        // Simpan data pelanggan ke tabel pelanggans
        $pelanggan = Pelanggan::create([
            'nama'  => $request->nama_pelanggan,
            'no_hp' => '-' 
        ]);

        // Hitung total harga keranjang
        $total = 0;
        foreach($cart as $item) {
            $total += $item['harga'] * $item['jumlah'];
        }

        // Simpan ke tabel pesanans sesuai format Khirpen
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

        // PERBAIKAN DI SINI: Menyertakan 'harga' ke dalam detail_pesanans
        foreach($cart as $id => $details) {
            DetailPesanan::create([
                'pesanan_id' => $pesanan->id,
                'menu_id'    => $id,
                'jumlah'     => $details['jumlah'],
                'harga'      => $details['harga'], // Menambahkan kolom harga sesuai keinginan database Khirpen
                'subtotal'   => $details['harga'] * $details['jumlah']
            ]);
        }

        // Ubah status meja menjadi 'Terisi'
        $meja->update(['status_meja' => 'Terisi']);

        // Hapus session keranjang belanja
        session()->forget('cart');

        return redirect()->route('tracking', ['id' => $pesanan->id])->with('success', 'Pesanan berhasil dibuat!');
    }

    // 7. HALAMAN TRACKING STATUS PESANAN PELANGGAN
    public function tracking($id)
    {
        $pesanan = Pesanan::with(['detailPesanan.menu', 'pelanggan', 'meja'])->findOrFail($id);
        return view('tracking', compact('pesanan'));
    }
}