<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Meja;

class MejaSeeder extends Seeder
{
    public function run(): void
    {
        for($i=1;$i<=10;$i++){

            Meja::create([
                'nomor_meja'=>'M'.str_pad($i,2,'0',STR_PAD_LEFT),
                'status_meja'=>'Tersedia'
            ]);

        }
    }
}