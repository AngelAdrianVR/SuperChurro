<?php

namespace App\Models;

use Carbon\Carbon;
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
        'discounts' => 'array',
    ];

    // methods
    public function weekAttendanceArray()
    {
        $user = User::find($this->user_id);
        $current_attendance = $this->attendance;
        $current_payroll = Payroll::find($this->payroll_id);
        $attendances = count($user->employee_properties['work_days']);
        $vacations = 0;
        $extras = 0; // minutes
        $late = 0; // minutes

        for ($i = 0; $i < 7; $i++) {
            if (!array_key_exists($i, $current_attendance)) {
                // check if this day is off, applied leave or holyday
                $current_attendance[$i] = $this->typeOfAbsent($current_payroll->start_date->addDays($i));

                if ($current_attendance[$i]['in'] === 'Vacaciones') $vacations++;
                else $attendances--;
            } else if ($current_attendance[$i]['out'] !== '--:--:--') {
                // calculate extras
                $extras_per_day = Carbon::parse($current_attendance[$i]['out'])
                    ->diffInMinutes($user->getEntryTime()) - $user->getTimeToWork();
                if ($extras_per_day < 0) $extras_per_day = 0;
                $extras += $extras_per_day;

                // late
                // serch for "permiso de llegada tarde" for this day
                $late_entry_permit = WorkPermit::whereDate('date', $current_payroll->start_date->addDays($i))
                    ->where('user_id', $this->user_id)
                    ->where('permission_type_id', 1)
                    ->where('status', WorkPermit::STATUS_APPROVED)
                    ->first();
                $late_per_day = $user->getEntryTime()
                    ->diffInMinutes(Carbon::parse($current_attendance[$i]['in']), false);

                if ($late_entry_permit) $late_per_day -= $late_entry_permit->time_requested;

                if ($late_per_day < 0) $late_per_day = 0;
                $late += $late_per_day;
            }

            // add day in the register
            $current_attendance[$i]['day'] = $current_payroll
                ->start_date
                ->addDays($i)
                ->isoFormat('dd, DD/MMM/YYYY');
        }

        return [
            'payroll' => collect($current_attendance),
            'attendances' => $attendances,
            'vacations' => $vacations,
            'extras' => $user->employee_properties['shift'] === "carrito vespertino" ? $extras : 0,
            'late' => $late,
        ];
    }

    private function typeOfAbsent($date)
    {
        if ($this->isDayOff($date->dayOfWeek)) $absent_type = "Día de descanso";
        else if ($this->isVacation($date)) $absent_type = "Vacaciones";
        else if ($this->isLeave($date)) $absent_type = "Permiso aprobado";
        else if ($this->isHoliday($date)) $absent_type = "Día feriado";
        else if ($date->greaterThanOrEqualTo(today())) $absent_type = "--:--:--";
        else $absent_type = "Falta";

        $attendance = [
            'in' => $absent_type,
            'out' => $absent_type
        ];

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
        $total = $this->baseSalary() +
            $this->vacationPremium() +
            $this->commissions() +
            $this->salaryForExtras() -
            collect($this->discounts)->sum('amount');

        return round($total);
    }

    public function baseSalary()
    {
        $base_salary = User::find($this->user_id)->employee_properties['base_salary'];
        return $this->weekAttendanceArray()['attendances'] * $base_salary;
    }

    public function salaryForExtras()
    {
        $base_salary = User::find($this->user_id)->employee_properties['base_salary'];
        $pesos_per_minute =  $base_salary / 360;
        $extras = $this->weekAttendanceArray()['extras'] * $pesos_per_minute;

        return $extras;
    }

    public function vacationPremium()
    {
        $base_salary = User::find($this->user_id)->employee_properties['base_salary'];
        $vacation_days = $this->weekAttendanceArray()['vacations'];

        return 0.25 * $base_salary * $vacation_days;
    }

    public function commissions()
    {
        $current_payroll = Payroll::find($this->payroll_id);

        if ($current_payroll->is_active) return null;

        return collect($current_payroll->commissions['amounts'])->sum();
    }
}
