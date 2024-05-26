<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsumableResource extends JsonResource
{
    
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'low_stock' => $this->low_stock,
            'unit' => $this->whenLoaded('unit'),
            'notes' => $this->notes,
            'media' => $this->getMedia()->all(),
            'created_at' => $this->created_at?->isoFormat('DD MMM YYYY'),
            'updated_at' => $this->updated_at?->isoFormat('DD MMM YYYY'), 
        ];
    }
}
