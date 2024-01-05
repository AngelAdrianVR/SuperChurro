<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
        'name' => $this->name,
        'email' => $this->email,
        'password' => $this->password,
        'is_admin' => $this->is_admin,
        'is_active' => $this->is_active,
        'loan_active' => $this->is_loan,
        'phone_number' => $this->phone_number,
        'profile_photo_url' => $this->profile_photo_url,
        'employee_properties' => $this->employee_properties,
        'created_at' => $this->created_at?->isoFormat('DD MMM YYYY'),
        'updated_at' => $this->updated_at?->isoFormat('DD MMM YYYY'),
        ];
    }
}
