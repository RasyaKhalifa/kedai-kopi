<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Pesanan;
use App\Models\Menu;
use App\Models\Meja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Tampilkan form login admin.
     */
    public function formLogin()
    {
        // Kalau sudah login, langsung lempar ke dashboard
        if (session('admin_id')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    /**
     * Proses login admin.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return back()
                ->withInput($request->only('username'))
                ->with('error', 'Username atau password salah.');
        }

        session([
            'admin_id'   => $admin->id,
            'admin_nama' => $admin->nama,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Selamat datang, ' . $admin->nama . '!');
    }

    /**
     * Logout admin.
     */
    public function logout()
    {
        session()->forget(['admin_id', 'admin_nama']);
        return redirect()->route('admin.login')->with('success', 'Berhasil logout.');
    }

    /**
     * Dashboard statistik.
     */
    public function dashboard()
    {
        $hariIni = Carbon::today();

        $pesananHariIni = Pesanan::whereDate('tanggal_pesanan', $hariIni)->count();

        $penjualanHariIni = Pesanan::where('status_pembayaran', 'Lunas')
            ->whereDate('tanggal_pesanan', $hariIni)
            ->sum('total_harga');

        $pesananPending = Pesanan::where('status_pesanan', 'Pending')->count();
        $pesananMemasak = Pesanan::where('status_pesanan', 'Memasak')->count();
        
        // 🔴 PERBAIKAN DI SINI: Hanya hitung pesanan selesai yang STATUS PEMBAYARANNYA masih 'Belum Bayar'
        $pesananSelesai = Pesanan::where('status_pesanan', 'Selesai')
            ->where('status_pembayaran', 'Belum Bayar')
            ->count();

        $totalMenu = Menu::count();
        $menuHabis = Menu::where('status_stok', 'Habis')->count();

        $totalMeja = Meja::count();
        $mejaTerisi = Meja::where('status_meja', 'Terisi')->count();

        // Penjualan 7 hari terakhir untuk grafik sederhana
        $penjualan7Hari = collect(range(6, 0))->map(function ($i) {
            $tanggal = Carbon::today()->subDays($i);
            return [
                'tanggal' => $tanggal->format('d/m'),
                'total'   => Pesanan::where('status_pembayaran', 'Lunas')
                    ->whereDate('tanggal_pesanan', $tanggal)
                    ->sum('total_harga'),
            ];
        });

        $menuTerlaris = \App\Models\DetailPesanan::whereHas('pesanan', function ($q) {
                $q->where('status_pembayaran', 'Lunas');
            })
            ->with('menu')
            ->get()
            ->groupBy(fn ($d) => $d->menu->nama_menu ?? 'Menu tidak diketahui')
            ->map(fn ($items, $nama) => ['nama' => $nama, 'qty' => $items->sum('jumlah')])
            ->sortByDesc('qty')
            ->take(5)
            ->values();

        return view('admin.dashboard', compact(
            'pesananHariIni',
            'penjualanHariIni',
            'pesananPending',
            'pesananMemasak',
            'pesananSelesai',
            'totalMenu',
            'menuHabis',
            'totalMeja',
            'mejaTerisi',
            'penjualan7Hari',
            'menuTerlaris'
        ));
    }
}