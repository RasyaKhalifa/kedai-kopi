<?php
// ============================================================
// FILE: app/Models/Pesanan.php
// ============================================================

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_pesanan',
        'meja_id',
        'nama_pelanggan',
        'catatan_umum',
        'total_harga',
        'status',       // pending | memasak | selesai | dibayar | batal
    ];

    // Relasi ke meja
    public function meja()
    {
        return $this->belongsTo(Meja::class);
    }

    // Relasi ke detail pesanan
    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class);
    }
}


// ============================================================
// FILE: app/Models/DetailPesanan.php
// ============================================================
// (Buat file terpisah di app/Models/DetailPesanan.php)

/*
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailPesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pesanan_id',
        'menu_id',
        'qty',
        'harga',
        'catatan',
        'subtotal',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
*/
