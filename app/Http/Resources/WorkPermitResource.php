<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkPermitResource extends JsonResource
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
            'id'=> $this->id,
            'date' => $this->date->isoFormat('DD MMM YYYY'),
            'created_at' => $this->created_at->isoFormat('DD MMM YYYY'),
            'time_requested' => $this->time_requested,
            'description' => $this->description,
            'status' => $this->status,
            'permission_type_id' => $this->permission_type_id,
            'user_id' => $this->user_id,
        ];
    }
}
