<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsumableRequestResource extends JsonResource
{
    
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'consumables' => $this->consumables,
            'cart_id' => $this->cart_id,
            'user'=>$this->whenLoaded('user'),
            'created_at' => $this->created_at?->isoFormat('DD MMM YYYY'),
        ];
    }
}
