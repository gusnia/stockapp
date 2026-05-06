<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class MarketController extends Controller
{
    public function watch(): View
    {
        return view('market.watch');
    }
}
