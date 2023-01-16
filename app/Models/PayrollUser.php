<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PayrollUser extends Pivot
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    protected $fillable = [
        'attendance',
        'discounts',
    ];

    protected $casts = [
        'attendance' => 'array',
    ];

    // methods
    public function weekAttendanceArray()
    {
        $current_attendance = $this->attendance;
        $current_payroll = Payroll::find($this->payroll_id);
        $attendances = count(User::find($this->user_id)->employee_properties['work_days']);
        $vacations = 0;

        for ($i = 0; $i < 7; $i++) {
            if (!array_key_exists($i, $current_attendance)) {
                // check if this day is off, applied leave or holyday
                $current_attendance[$i] = $this->typeOfAbsent($current_payroll->start_date->addDays($i));

                if($current_attendance[$i]['in'] === 'Vacaciones') $vacations ++;
                else $attendances --;
            }

            // add day in the register
            $current_attendance[$i]['day'] = $current_payroll->start_date->addDays($i)->isoFormat('dd, DD/MMM/YYYY');
        }

        return [
            'payroll' => collect($current_attendance),
            'attendances' => $attendances,
            'vacations' => $vacations
        ];
    }

    private function typeOfAbsent($date)
    {
        $absent_type = "Falta";
        $attendance = [
            'in' => $absent_type,
            'out' => $absent_type
        ];

        if ($this->isDayOff($date->dayOfWeek)) $absent_type = "Día de descanso";
        if ($this->isVacation($date)) $absent_type = "Vacaciones";
        if ($this->isLeave($date)) $absent_type = "Permiso aprobado";
        if ($this->isHoliday($date)) $absent_type = "Día feriado";
        if ($date->greaterThanOrEqualTo(now())) $absent_type = "--:--:--";

        return $attendance;
    }

    private function isDayOff($day_of_week)
    {
        $user = User::find($this->user_id);
        $work_days = collect($user->employee_properties['work_days']);

        return $work_days->doesntContain($day_of_week);
    }

    private function isLeave($date)
    {
        $is_there_an_approved_leave = WorkPermit::where('user_id', $this->user_id)
            ->whereDate('date', $date)
            ->where('status', WorkPermit::STATUS_APPROVED)
            ->where('time_requested', 0)
            ->get()
            ->count();

        return $is_there_an_approved_leave;
    }

    private function isVacation($date)
    {
        $is_there_an_approved_vacation = WorkPermit::where('user_id', $this->user_id)
            ->whereDate('date', $date)
            ->where('status', WorkPermit::STATUS_APPROVED)
            ->where('permission_type_id', 3)
            ->get()
            ->count();

        return $is_there_an_approved_vacation;
    }

    private function isHoliday($date)
    {
        $is_holiday = Holiday::where('date', $date->isoFormat('DD-MM'))
            ->whereMonth('date', $date)
            ->get()
            ->count();

        return $is_holiday;
    }

    public function paid()
    {
        return $this->baseSalary() +
            $this->vacationPremium() +
            $this->salaryForExtras() -
            $this->discounts;
    }

    private function baseSalary()
    {
        $base_salary = User::find($this->user_id)->employee_properties['base_salary'];
        return $this->weekAttendanceArray()['attendances'] * $base_salary;
    }

    private function salaryForExtras()
    {
        return 0;
    }

    public function vacationPremium()
    {
        $base_salary = User::find($this->user_id)->employee_properties['base_salary'];
        $vacation_days = $this->weekAttendanceArray()['vacations'];

        return 0.25 * $base_salary * $vacation_days;
    }

}
