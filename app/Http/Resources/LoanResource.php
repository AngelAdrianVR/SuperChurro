<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LoanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'amount' => number_format($this->amount),
            'created_at' => $this->created_at->isoFormat('DD MMM YYYY'),
            'payed_at' => $this->payed_at?->isoFormat('DD MMM YYYY'),
            'status' => $this-> status,
            'description' => $this-> description,
            'user_id' => $this-> user_id,
        ];
    }
}
