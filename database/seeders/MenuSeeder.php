<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        Menu::insert([

            [
                'kategori_id'=>1,
                'nama_menu'=>'Espresso',
                'harga'=>18000,
                'stok'=>100,
                'status_stok'=>'Tersedia',
                'foto'=>'espresso.jpg'
            ],

            [
                'kategori_id'=>1,
                'nama_menu'=>'Americano',
                'harga'=>22000,
                'stok'=>100,
                'status_stok'=>'Tersedia',
                'foto'=>'americano.jpg'
            ],

            [
                'kategori_id'=>1,
                'nama_menu'=>'Cafe Latte',
                'harga'=>30000,
                'stok'=>100,
                'status_stok'=>'Tersedia',
                'foto'=>'latte.jpg'
            ],

            [
                'kategori_id'=>2,
                'nama_menu'=>'Matcha Latte',
                'harga'=>28000,
                'stok'=>100,
                'status_stok'=>'Tersedia',
                'foto'=>'matcha.jpg'
            ],

            [
                'kategori_id'=>3,
                'nama_menu'=>'French Fries',
                'harga'=>20000,
                'stok'=>100,
                'status_stok'=>'Tersedia',
                'foto'=>'fries.jpg'
            ],

            [
                'kategori_id'=>4,
                'nama_menu'=>'Nasi Goreng',
                'harga'=>30000,
                'stok'=>100,
                'status_stok'=>'Tersedia',
                'foto'=>'nasigoreng.jpg'
            ]

        ]);
    }
}