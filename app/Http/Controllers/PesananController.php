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

        // Ambil data meja asli
        $meja = Meja::where('nomor_meja', $request->nomor_meja)->first();
        if (!$meja) {
            return redirect()->back()->with('error', 'Nomor meja tidak valid!');
        }

        // PROTEKSI GANDA: Cek jika meja sudah terisi oleh pelanggan lain sebelum order diproses
        // Gunakan strcasecmp agar pengecekan string 'Terisi' tidak sensitif huruf besar/kecil
        if (strcasecmp($meja->status_meja, 'Terisi') === 0 || strcasecmp($meja->status_meja, 'Penuh') === 0) {
            return redirect()->route('menu.index')->with('error', 'Maaf, Meja ' . $meja->nomor_meja . ' baru saja terisi. Silakan hubungi kasir.');
        }

        // 1. Simpan Data Pelanggan
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
            'meja_id'           => $meja->id, // Sudah dipastikan mencatat ID asli meja
            'pelanggan_id'      => $pelanggan->id,
            'admin_id'          => null,
            'tanggal_pesanan'   => Carbon::now(),
            'total_harga'       => $total,
            'status_pesanan'    => 'Pending',
            'status_pembayaran' => 'Belum Bayar',
            'metode_pembayaran' => null
        ]);

        // 3. Looping untuk simpan ke tabel detail_pesanans
        foreach($cart as $id => $details) {
            DetailPesanan::create([
                'pesanan_id' => $pesanan->id,
                'menu_id'    => $id,
                'jumlah'     => $details['jumlah'],
                'harga'      => $details['harga'],
                'subtotal'   => $details['harga'] * $details['jumlah']
            ]);
        }

        // 4. JALUR AMAN: Update status meja menjadi 'Terisi' langsung di database
        $meja->update(['status_meja' => 'Terisi']);

        // Hapus keranjang belanja di sesi setelah sukses order
        session()->forget('cart');

        return redirect()->route('tracking', ['id' => $pesanan->id])->with('success', 'Pesanan sukses dibuat!');
    }

    public function tracking($id)
    {
        $pesanan = Pesanan::with(['detailPesanan.menu', 'pelanggan', 'meja'])->findOrFail($id);
        return view('tracking', compact('pesanan'));
    }
}