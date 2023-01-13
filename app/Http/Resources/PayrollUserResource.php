<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PayrollUserResource extends JsonResource
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
            'week' => $this->week,
            'start_date' => $this->start_date->isoFormat('DD/MMMM/YYYY'),
            'end_date' => $this->start_date->addDays(6)->isoFormat('DD/MMMM/YYYY'),
            'week_attendance' => $this->pivot->weekAttendanceArray(),
            'discounts' => $this->pivot->discounts,
        ];
    }
}
