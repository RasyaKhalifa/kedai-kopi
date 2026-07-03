<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Meja;

class DashboardController extends Controller
{

    public function index()
    {

        return view('admin.dashboard',[

            'jumlahMenu'=>Menu::count(),

            'jumlahMeja'=>Meja::count(),

            'menuAktif'=>Menu::where('status',1)->count(),

        ]);

    }

}