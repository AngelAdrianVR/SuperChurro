<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductRequestHistoryResource extends JsonResource
{
    
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'products' => $this->products,
            'cart_id' => $this->cart_id,
            'user'=>$this->whenLoaded('user'),
            'created_at' => $this->created_at?->isoFormat('DD MMM YYYY'),
        ];
    }
}
