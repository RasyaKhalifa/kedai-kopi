<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggans';
    
    // Ganti nama_pelanggan menjadi nama sesuai database Khirpen
    protected $fillable = ['nama','no_hp']; 

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'pelanggan_id');
    }
}