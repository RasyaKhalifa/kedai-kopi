<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KasirController extends Controller
{
    /**
     * Dashboard kasir: semua pesanan masuk, dikelompokkan per status_pesanan.
     */
    public function index()
    {
        $pesananPending = Pesanan::with(['detailPesanan.menu', 'meja', 'pelanggan'])
            ->where('status_pesanan', 'Pending')
            ->orderBy('tanggal_pesanan')
            ->get();

        $pesananMemasak = Pesanan::with(['detailPesanan.menu', 'meja', 'pelanggan'])
            ->where('status_pesanan', 'Memasak')
            ->orderBy('tanggal_pesanan')
            ->get();

        // Selesai dimasak tapi belum dibayar -> siap kasir proses pembayaran
        $pesananSiapBayar = Pesanan::with(['detailPesanan.menu', 'meja', 'pelanggan'])
            ->where('status_pesanan', 'Selesai')
            ->where('status_pembayaran', 'Belum Bayar')
            ->orderBy('tanggal_pesanan')
            ->get();

        return view('kasir.index', compact('pesananPending', 'pesananMemasak', 'pesananSiapBayar'));
    }

    /**
     * Ubah status_pesanan: Pending -> Memasak -> Selesai.
     * Dipakai kasir untuk override manual (dapur biasanya update lewat DapurController).
     */
    public function updateStatus(Request $request, Pesanan $pesanan)
    {
        $request->validate([
            'status_pesanan' => 'required|in:Pending,Memasak,Selesai,Dibatalkan',
        ]);

        $urutan = ['Pending' => 1, 'Memasak' => 2, 'Selesai' => 3, 'Dibatalkan' => 0];

        if ($request->status_pesanan !== 'Dibatalkan'
            && $urutan[$request->status_pesanan] < $urutan[$pesanan->status_pesanan]) {
            return back()->with('error', 'Status tidak bisa dikembalikan mundur.');
        }

        $pesanan->update(['status_pesanan' => $request->status_pesanan]);

        // JALUR AMAN: Jika pesanan dibatalkan, otomatis bebaskan meja kembali menjadi 'Tersedia'
        if ($request->status_pesanan === 'Dibatalkan' && $pesanan->meja) {
            $pesanan->meja->update(['status_meja' => 'Tersedia']);
        }

        return back()->with('success', "Status pesanan #{$pesanan->id} diubah menjadi {$request->status_pesanan}.");
    }

    /**
     * Form pembayaran untuk 1 pesanan.
     */
    public function formBayar(Pesanan $pesanan)
    {
        if ($pesanan->status_pesanan !== 'Selesai') {
            return back()->with('error', 'Pesanan belum selesai dimasak, belum bisa dibayar.');
        }

        if ($pesanan->status_pembayaran === 'Lunas') {
            return redirect()->route('kasir.struk', $pesanan->id)->with('success', 'Pesanan ini sudah lunas.');
        }

        $pesanan->load('detailPesanan.menu', 'meja', 'pelanggan');
        return view('kasir.pembayaran', compact('pesanan'));
    }

    /**
     * Proses pembayaran: set status_pembayaran = Lunas, simpan metode pembayaran,
     * dan bebaskan meja setelah transaksi selesai.
     */
    public function prosesBayar(Request $request, Pesanan $pesanan)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:Tunai,QRIS',
            'jumlah_bayar'       => 'required|numeric|min:' . $pesanan->total_harga,
        ]);

        $pesanan->update([
            'status_pembayaran' => 'Lunas',
            'metode_pembayaran' => $request->metode_pembayaran,
        ]);

        // Otomatis membebaskan status meja menjadi 'Tersedia' setelah pembayaran sukses
        if ($pesanan->meja) {
            $pesanan->meja->update(['status_meja' => 'Tersedia']);
        }

        // Simpan info bayar & kembalian sementara di session untuk ditampilkan di struk
        session([
            'kembalian_' . $pesanan->id => $request->jumlah_bayar - $pesanan->total_harga,
            'jumlah_bayar_' . $pesanan->id => $request->jumlah_bayar,
        ]);

        return redirect()->route('kasir.struk', $pesanan->id)->with('success', 'Pembayaran berhasil.');
    }

    /**
     * Cetak struk pembayaran.
     */
    public function struk(Pesanan $pesanan)
    {
        $pesanan->load('detailPesanan.menu', 'meja', 'pelanggan');

        $jumlahBayar = session('jumlah_bayar_' . $pesanan->id, $pesanan->total_harga);
        $kembalian   = session('kembalian_' . $pesanan->id, 0);

        return view('kasir.struk', compact('pesanan', 'jumlahBayar', 'kembalian'));
    }

    /**
     * Laporan penjualan (rentang tanggal, default hari ini).
     */
    public function laporan(Request $request)
    {
        $dari   = $request->query('dari', Carbon::today()->toDateString());
        $sampai = $request->query('sampai', Carbon::today()->toDateString());

        $pesananLunas = Pesanan::with(['detailPesanan.menu', 'meja', 'pelanggan'])
            ->where('status_pembayaran', 'Lunas')
            ->whereDate('tanggal_pesanan', '>=', $dari)
            ->whereDate('tanggal_pesanan', '<=', $sampai)
            ->orderBy('tanggal_pesanan')
            ->get();

        $totalPenjualan  = $pesananLunas->sum('total_harga');
        $jumlahTransaksi = $pesananLunas->count();

        $menuTerlaris = $pesananLunas
            ->flatMap(fn ($p) => $p->detailPesanan)
            ->groupBy(fn ($d) => $d->menu->nama_menu ?? 'Menu tidak diketahui')
            ->map(fn ($items, $nama) => [
                'nama'  => $nama,
                'qty'   => $items->sum('jumlah'),
                'total' => $items->sum('subtotal'),
            ])
            ->sortByDesc('qty')
            ->values();

        return view('kasir.laporan', compact(
            'pesananLunas',
            'totalPenjualan',
            'jumlahTransaksi',
            'menuTerlaris',
            'dari',
            'sampai'
        ));
    }
}