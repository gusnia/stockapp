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
    $mockData = [
        'BBCA' => ['price' => 9450, 'change' => 2.34, 'volume' => '128.4M', 'market_cap' => '1.17T', 'sector' => 'Keuangan'],
        'TLKM' => ['price' => 3820, 'change' => -1.03, 'volume' => '89.2M', 'market_cap' => '376.8B', 'sector' => 'Teknologi'],
        'UNVR' => ['price' => 20000, 'change' => 0.85, 'volume' => '62.7M', 'market_cap' => '213.5B', 'sector' => 'Konsumer'],
        'ASII' => ['price' => 5275, 'change' => 1.46, 'volume' => '45.1M', 'market_cap' => '121.3B', 'sector' => 'Otomotif'],
        'ICBP' => ['price' => 10450, 'change' => -2.18, 'volume' => '31.6M', 'market_cap' => '98.7B', 'sector' => 'Konsumer'],
    ];

    $companies = \App\Models\Company::passesShariaScreening()->get()->map(function ($company) use ($mockData) {
        $mock = $mockData[$company->ticker] ?? ['price' => 0, 'change' => 0, 'volume' => '0', 'market_cap' => '0', 'sector' => '-'];
        return array_merge($company->toArray(), $mock);
    });

    return response()->json(['data' => $companies]);
});
