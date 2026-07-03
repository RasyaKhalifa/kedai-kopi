<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meja;
use Illuminate\Http\Request;

class MejaController extends Controller
{
    /**
     * Daftar semua meja.
     */
    public function index()
    {
        $meja = Meja::orderBy('nomor_meja')->get();
        return view('admin.meja.index', compact('meja'));
    }

    /**
     * Form tambah meja.
     */
    public function create()
    {
        return view('admin.meja.create');
    }

    /**
     * Simpan meja baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor_meja' => 'required|string|max:20|unique:mejas,nomor_meja',
        ]);

        Meja::create([
            'nomor_meja'  => $request->nomor_meja,
            'status_meja' => 'Tersedia',
        ]);

        return redirect()->route('admin.meja.index')->with('success', 'Meja berhasil ditambahkan.');
    }

    /**
     * Form edit meja.
     */
    public function edit(Meja $meja)
    {
        return view('admin.meja.edit', compact('meja'));
    }

    /**
     * Update meja.
     */
    public function update(Request $request, Meja $meja)
    {
        $request->validate([
            'nomor_meja'  => 'required|string|max:20|unique:mejas,nomor_meja,' . $meja->id,
            'status_meja' => 'required|in:Tersedia,Terisi',
        ]);

        $meja->update($request->only(['nomor_meja', 'status_meja']));

        return redirect()->route('admin.meja.index')->with('success', 'Meja berhasil diperbarui.');
    }

    /**
     * Hapus meja.
     */
    public function destroy(Meja $meja)
    {
        if ($meja->status_meja === 'Terisi') {
            return back()->with('error', 'Meja sedang terisi, tidak bisa dihapus.');
        }

        $meja->delete();

        return redirect()->route('admin.meja.index')->with('success', 'Meja berhasil dihapus.');
    }

    /**
     * Tampilkan / cetak QR Code meja.
     * QR mengarah ke halaman menu customer dengan query ?meja=nomor_meja,
     * sesuai yang sudah dibaca MenuController@index (session nomor_meja).
     */
    public function qrcode(Meja $meja)
    {
        $urlMenu = url('/?meja=' . urlencode($meja->nomor_meja));

        $qrImageUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($urlMenu);

        return view('admin.meja.qrcode', compact('meja', 'urlMenu', 'qrImageUrl'));
    }
}
