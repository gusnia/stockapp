<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $companies = [
            // Lolos screening: debt ratio < 45%
            [
                'ticker'       => 'BBCA',
                'company_name' => 'Bank Central Asia Tbk',
                'total_assets' => 1_408_000_000_000,
                'total_debt'   => 450_000_000_000,  // ratio ~31.9%
                'is_sharia'    => true,
            ],
            [
                'ticker'       => 'TLKM',
                'company_name' => 'Telkom Indonesia Tbk',
                'total_assets' => 275_000_000_000,
                'total_debt'   => 95_000_000_000,   // ratio ~34.5%
                'is_sharia'    => true,
            ],
            [
                'ticker'       => 'UNVR',
                'company_name' => 'Unilever Indonesia Tbk',
                'total_assets' => 20_000_000_000,
                'total_debt'   => 7_500_000_000,    // ratio ~37.5%
                'is_sharia'    => false,
            ],
            [
                'ticker'       => 'ASII',
                'company_name' => 'Astra International Tbk',
                'total_assets' => 320_000_000_000,
                'total_debt'   => 130_000_000_000,  // ratio ~40.6%
                'is_sharia'    => true,
            ],
            [
                'ticker'       => 'ICBP',
                'company_name' => 'Indofood CBP Sukses Makmur Tbk',
                'total_assets' => 55_000_000_000,
                'total_debt'   => 20_000_000_000,   // ratio ~36.3%
                'is_sharia'    => true,
            ],
            // Tidak lolos screening: debt ratio >= 45%
            [
                'ticker'       => 'BMRI',
                'company_name' => 'Bank Mandiri Tbk',
                'total_assets' => 1_800_000_000_000,
                'total_debt'   => 1_100_000_000_000, // ratio ~61.1%
                'is_sharia'    => false,
            ],
            [
                'ticker'       => 'BBRI',
                'company_name' => 'Bank Rakyat Indonesia Tbk',
                'total_assets' => 1_900_000_000_000,
                'total_debt'   => 1_200_000_000_000, // ratio ~63.1%
                'is_sharia'    => false,
            ],
            [
                'ticker'       => 'SMGR',
                'company_name' => 'Semen Indonesia Tbk',
                'total_assets' => 78_000_000_000,
                'total_debt'   => 38_000_000_000,    // ratio ~48.7%
                'is_sharia'    => true,
            ],
            [
                'ticker'       => 'PGAS',
                'company_name' => 'Perusahaan Gas Negara Tbk',
                'total_assets' => 92_000_000_000,
                'total_debt'   => 52_000_000_000,    // ratio ~56.5%
                'is_sharia'    => true,
            ],
            [
                'ticker'       => 'ANTM',
                'company_name' => 'Aneka Tambang Tbk',
                'total_assets' => 30_000_000_000,
                'total_debt'   => 15_000_000_000,    // ratio ~50.0%
                'is_sharia'    => false,
            ],
        ];

        foreach ($companies as $data) {
            Company::create($data);
        }
    }
}
