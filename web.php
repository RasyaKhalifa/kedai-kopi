<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MejaController;

Route::middleware(['auth'])->group(function (){

    Route::get('/dashboard',[DashboardController::class,'index']);

    Route::resource('menu',MenuController::class);

    Route::resource('meja',MejaController::class);

});