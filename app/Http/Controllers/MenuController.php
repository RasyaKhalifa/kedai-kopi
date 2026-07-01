<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Kategori;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil nomor meja dari query string (misal: ?meja=M01) dan simpan di session
        if ($request->has('meja')) {
            session(['nomor_meja' => $request->meja]);
        }

        $kategoris = Kategori::with('menus')->get();
        $menus = Menu::where('status_stok', 'Tersedia')->get();

        return view('home', compact('kategoris', 'menus'));
    }
}