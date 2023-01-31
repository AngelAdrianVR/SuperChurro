<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserPayrollResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'week_attendance' => $this->pivot->weekAttendanceArray(),
            'discounts' => $this->pivot->discounts,
            'paid' => number_format($this->pivot->paid(), 2),
            'vacation_premium' => $this->pivot->vacationPremium(),
            'base_salary' => number_format($this->pivot->baseSalary()),
            'is_active' => $this->is_active,
            'commissions' => $this->pivot->commissions(),
            'salary_for_extras' => round($this->pivot->salaryForExtras()),
            'user' => UserResource::make(User::find($this->pivot->user_id))
        ];
    }
}
