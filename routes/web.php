<?php

use App\Http\Controllers\MarketController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [MarketController::class, 'watch'])->name('market.watch');
Route::get('/market', [MarketController::class, 'watch'])->name('market.watch');
