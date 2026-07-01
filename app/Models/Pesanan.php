<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanans';
    
    // Sesuaikan kolomnya dengan migration milik Khirpen
    protected $fillable = [
        'meja_id', 
        'pelanggan_id', 
        'admin_id', 
        'tanggal_pesanan', 
        'total_harga', 
        'status_pesanan', 
        'status_pembayaran', 
        'metode_pembayaran'
    ];

    public function meja()
    {
        return $this->belongsTo(Meja::class, 'meja_id');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    }
}