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
            'description' => $this-> description,
            'user' => UserResource::make($this->whenLoaded('user')),
            'remaining' => number_format($this->remaining),
            'authorized_at' => $this->authorized_at?->isoFormat('DD MMM YYYY'),
        ];
    }
}
