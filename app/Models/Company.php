<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Company extends Model
{
    protected $table = 'companies';
    protected $fillable = [
        'ticker',
        'company_name',
        'total_assets',
        'total_debt',
        'is_sharia',
    ];

    protected $casts = [
        'total_assets' => 'float',
        'total_debt'   => 'float',
        'is_sharia'    => 'boolean',
    ];



    // line ini untuk menghitung rasio utang: total_debt / total_assets
    public function getDebtRatioAttribute(): float
    {

        if ($this->total_assets == 0) {
            return 0;
        }

        return $this->total_debt / $this->total_assets;
    }

    // line ini scope untuk filter perusahaan yang debt ratio-nya di bawah 45%
    public function scopePassesShariaScreening(Builder $query): Builder
    {
        return $query->whereRaw('total_assets != 0 AND (total_debt / total_assets) < 0.45');
    }
}
