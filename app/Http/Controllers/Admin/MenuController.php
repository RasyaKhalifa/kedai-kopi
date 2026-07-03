<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// ⚠️ DI SINI BIANG KEROKNYA TADI! Pastikan namanya 'MenuController', BUKAN 'MejaController'
class MenuController extends Controller
{
    /**
     * Daftar semua menu.
     */
    public function index()
    {
        $menu = Menu::with('kategori')->orderBy('nama_menu')->get();
        return view('admin.menu.index', compact('menu'));
    }

    /**
     * Form tambah menu.
     */
    public function create()
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();
        return view('admin.menu.create', compact('kategori'));
    }

    /**
     * Simpan menu baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama_menu'   => 'required|string|max:255',
            'harga'       => 'required|integer|min:0',
            'stok'        => 'required|integer|min:0',
            'foto'        => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['kategori_id', 'nama_menu', 'harga', 'stok']);
        $data['status_stok'] = $request->stok > 0 ? 'Tersedia' : 'Habis';

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('menu', 'public');
        }

        Menu::create($data);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    /**
     * Form edit menu.
     */
    public function edit(Menu $menu)
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();
        return view('admin.menu.edit', compact('menu', 'kategori'));
    }

    /**
     * Update menu.
     */
    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama_menu'   => 'required|string|max:255',
            'harga'       => 'required|integer|min:0',
            'stok'        => 'required|integer|min:0',
            'foto'        => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['kategori_id', 'nama_menu', 'harga', 'stok']);
        $data['status_stok'] = $request->stok > 0 ? 'Tersedia' : 'Habis';

        if ($request->hasFile('foto')) {
            if ($menu->foto) {
                Storage::disk('public')->delete($menu->foto);
            }
            $data['foto'] = $request->file('foto')->store('menu', 'public');
        }

        $menu->update($data);

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil diperbarui.');
    }

    /**
     * Hapus menu.
     */
    public function destroy(Menu $menu)
    {
        if ($menu->foto) {
            Storage::disk('public')->delete($menu->foto);
        }

        $menu->delete();

        return redirect()->route('admin.menu.index')->with('success', 'Menu berhasil dihapus.');
    }
}