<?php

namespace App\Http\Resources;

use App\Models\Payroll;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class PayrollUserResource2 extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'week_attendance' => $this->weekAttendanceArray(),
            'discounts' => $this->discounts(),
            'extras' => $this->extras,
            'total_extras' => $this->extraTime(),
            'paid' => number_format($this->paid(), 2),
            'vacation_premium' => $this->vacationPremium(),
            'base_salary' => number_format($this->baseSalary()),
            'commissions' => $this->commissions(),
            'bonuses' => $this->bonuses(),
            'salary_for_extras' => number_format(round($this->salaryForExtras())), 
            'vacations_not_taken' => number_format(round($this->PayVacations())),
            'user' => UserResource::make(User::find($this->user_id)),
            'payroll' => PayrollResource::make(Payroll::find($this->payroll_id))
        ];
    }
}
