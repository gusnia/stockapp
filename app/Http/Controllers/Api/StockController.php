<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class StockController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $companies = Company::passesShariaScreening()->get();

        return CompanyResource::collection($companies);
    }
}
