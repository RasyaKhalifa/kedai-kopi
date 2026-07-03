<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class DapurController extends Controller
{
    /**
     * Dashboard dapur: pesanan yang perlu dikerjakan (Pending & Memasak).
     * Pesanan "Selesai" ditampilkan sebentar (10 terakhir) sebagai riwayat.
     */
    public function index()
    {
        $pesananPending = Pesanan::with(['detailPesanan.menu', 'meja'])
            ->where('status_pesanan', 'Pending')
            ->orderBy('tanggal_pesanan')
            ->get();

        $pesananMemasak = Pesanan::with(['detailPesanan.menu', 'meja'])
            ->where('status_pesanan', 'Memasak')
            ->orderBy('tanggal_pesanan')
            ->get();

        $pesananSelesai = Pesanan::with(['detailPesanan.menu', 'meja'])
            ->where('status_pesanan', 'Selesai')
            ->orderByDesc('updated_at')
            ->take(10)
            ->get();

        return view('dapur.index', compact('pesananPending', 'pesananMemasak', 'pesananSelesai'));
    }

    /**
     * Dapur mulai memasak: Pending -> Memasak.
     */
    public function mulaiMasak(Pesanan $pesanan)
    {
        if ($pesanan->status_pesanan !== 'Pending') {
            return back()->with('error', 'Pesanan ini sudah diproses sebelumnya.');
        }

        $pesanan->update(['status_pesanan' => 'Memasak']);

        return back()->with('success', "Pesanan #{$pesanan->id} mulai dimasak.");
    }

    /**
     * Dapur menandai selesai: Memasak -> Selesai (siap dibayar kasir).
     */
    public function selesaiMasak(Pesanan $pesanan)
    {
        if ($pesanan->status_pesanan !== 'Memasak') {
            return back()->with('error', 'Pesanan ini belum dalam proses memasak.');
        }

        $pesanan->update(['status_pesanan' => 'Selesai']);

        return back()->with('success', "Pesanan #{$pesanan->id} selesai dimasak, siap dibayar di kasir.");
    }
}
