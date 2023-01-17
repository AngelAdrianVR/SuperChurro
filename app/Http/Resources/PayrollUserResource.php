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
            'start_date' => $this->start_date->isoFormat('DD/MMM/YYYY'),
            'end_date' => $this->start_date->addDays(6)->isoFormat('DD/MMM/YYYY'),
            'week_attendance' => $this->pivot->weekAttendanceArray(),
            'discounts' => $this->pivot->discounts,
            'paid' => number_format($this->pivot->paid(), 2),
            'vacation_premium' => $this->pivot->vacationPremium(),
            'base_salary' => number_format($this->pivot->baseSalary()),
            'is_active' => $this->is_active,
            'commissions' => round($this->pivot->commissions()),
            'salary_for_extras' => round($this->pivot->salaryForExtras()), 
        ];
    }
}
