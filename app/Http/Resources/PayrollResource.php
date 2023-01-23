<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PayrollResource extends JsonResource
{
    
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'week' => $this->week,
            'week_commissions' => $this->commissions,
            'start_date' => $this->start_date->isoFormat('DD/MMM/YYYY'),
            'end_date' => $this->start_date->addDays(6)->isoFormat('DD/MMM/YYYY'),
            'users' => UserPayrollResource::collection($this->whenLoaded('users')),
            'is_active' => $this->is_active,
        ];
    }
}
