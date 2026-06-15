<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicineAlternativeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'genericName' => $this->generic_name,
            'strength' => $this->strength,
            'brand' => $this->brand,
            'price' => (float) $this->price,
            'formattedPrice' => '৳ ' . number_format($this->price, 2),
            'stripPrice' => $this->strip_price ? (float) $this->strip_price : null,
            'formattedStripPrice' => $this->strip_price ? '৳ ' . number_format($this->strip_price, 2) : null,
        ];
    }
}
