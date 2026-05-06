<?php

use App\Http\Controllers\MarketController;
use App\Http\Controllers\Api\StockController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api/sharia-stocks', [StockController::class, 'index']);

Route::get('/', [MarketController::class, 'watch'])->name('market.watch');
Route::get('/market', [MarketController::class, 'watch'])->name('market.watch');


Route::get('/debug-db', function () {
    try {
        DB::connection()->getPdo();
        $tables = DB::select('SHOW TABLES');
        $count = DB::table('companies')->count();
        return [
            'status' => 'connected',
            'tables' => $tables,
            'companies_count' => $count,
        ];
    } catch (\Exception $e) {
        return [
            'status' => 'failed',
            'error' => $e->getMessage(),
        ];
    }
});


Route::get('/sharia-stocks', function () {
    $companies = \App\Models\Company::passesShariaScreening()->get();
    return response()->json(['data' => $companies]);
});
