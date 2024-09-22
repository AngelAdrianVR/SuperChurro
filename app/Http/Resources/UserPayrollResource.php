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
            'payroll_user_id' => $this->pivot->id,
            'week_attendance' => $this->pivot->weekAttendanceArray(),
            'discounts' => $this->pivot->discounts(),
            'additional' => $this->pivot->additional,
            'extras' => $this->pivot->extras,
            'paid' => number_format($this->pivot->paid(), 2),
            'raw_paid' => $this->pivot->paid(),
            'paid_vacations' => number_format($this->pivot->payVacations(), 2),
            'raw_vacations' => $this->pivot->payVacations(),
            'paid_leaves' => number_format($this->pivot->payLeaves(), 2),
            'paid_holiday' => number_format($this->pivot->payHoliday(), 2),
            'paid_sickness' => number_format($this->pivot->paySickness(), 2),
            'base_salary' => number_format($this->pivot->baseSalary()),
            'raw_base_salary' => $this->pivot->baseSalary(),
            'is_active' => $this->pivot->payroll->is_active,
            'commissions' => $this->pivot->commissions(),
            'bonuses' => $this->pivot->bonuses(),
            'salary_for_extras' => round($this->pivot->salaryForExtras()),
            'user' => UserResource::make(User::find($this->pivot->user_id))
        ];
    }
}
