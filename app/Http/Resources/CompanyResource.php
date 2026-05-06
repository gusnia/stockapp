<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'ticker'       => $this->ticker,
            'company_name' => $this->company_name,
            'total_assets' => $this->total_assets,
            'total_debt'   => $this->total_debt,
            'debt_ratio'   => round($this->debt_ratio * 100, 2), // convert to percentage
            'is_sharia'    => $this->is_sharia,
        ];
    }
}
