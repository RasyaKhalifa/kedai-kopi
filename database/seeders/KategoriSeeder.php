<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = [
            'Coffee',
            'Non Coffee',
            'Snack',
            'Makanan'
        ];

        foreach ($kategori as $item) {
            Kategori::create([
                'nama_kategori' => $item
            ]);
        }
    }
}