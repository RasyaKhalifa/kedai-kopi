<?php

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
        'status',
    ];

    public function meja()
    {
        return $this->belongsTo(Meja::class);
    }

    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class);
    }
}