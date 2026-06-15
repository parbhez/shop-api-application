<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicineResource extends JsonResource
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
            'slug' => $this->slug,
            'title' => $this->title,
            'genericName' => $this->generic_name,
            'strength' => $this->strength,
            'category' => $this->category,
            'price' => (float) $this->price,
            'formattedPrice' => '৳ ' . number_format($this->price, 2),
            'stripPrice' => $this->strip_price ? (float) $this->strip_price : null,
            'formattedStripPrice' => $this->strip_price ? '৳ ' . number_format($this->strip_price, 2) : null,
            'tags' => ['medicine', $this->category],
            'brand' => $this->brand,
            'availabilityStatus' => $this->availability_status,
            'thumbnail' => $this->thumbnail ?? 'https://cdn.dummyjson.com/products/images/beauty/Essence%20Mascara%20Lash%20Princess/thumbnail.png',
            'alternatives' => MedicineAlternativeResource::collection($this->whenLoaded('alternatives')),
        ];
    }
}
