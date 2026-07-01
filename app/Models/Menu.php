<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus'; // atau 'menu' sesuaikan dengan migrasi Anda
    protected $fillable = ['kategori_id', 'nama_menu', 'harga', 'stok', 'status_stok', 'foto'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}