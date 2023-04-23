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
        'additional',
        'extras',
        'discounts',
    ];

    protected $casts = [
        'attendance' => 'array',
        'additional' => 'array',
        'extras' => 'array',
        'discounts' => 'array',
    ];

    // relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }

    // methods
    public function weekAttendanceArray()
    {
        $current_payroll = Payroll::find($this->payroll_id);
        $current_attendance = $this->attendance;

        // return raw attendance if payroll is closed
        if (!$current_payroll->is_active) {
            return $current_attendance;
        }

        $user = User::find($this->user_id);
        $attendances = 7;
        $days_as_double = 0;
        $double_commission_on = [];
        $vacations = 0;
        $extras = 0; // minutes
        $late = 0; // minutes
        $tolerance = 15;

        for ($i = 0; $i < 7; $i++) {
            $current_day_in_loop = $current_payroll->start_date->addDays($i);
            if (!array_key_exists($i, $current_attendance)) {
                // check if this day is off, applied leave or holyday
                $current_attendance[$i] = $this->typeOfAbsent($current_day_in_loop);

                // add vacations or sub attendances
                if ($current_attendance[$i]['in'] !== 'Día feriado') $attendances--;
                if ($current_attendance[$i]['in'] == 'Vacaciones') $vacations++;

                // 
            } else if ($current_attendance[$i]['out'] !== '--:--:--') {
                // add aditional day salary (full day worked)
                if ($user->shiftOn($current_day_in_loop->dayOfWeek) === 'carrito 2 turnos' || $this->isHoliday($current_day_in_loop)) {
                    if ($user->shiftOn($current_day_in_loop->dayOfWeek) === 'carrito 2 turnos' && $this->isHoliday($current_day_in_loop)) {
                        $days_as_double += 3;
                    } else {
                        $days_as_double++;
                    }
                    $double_commission_on[] = $i;
                } else if ($user->shiftOn($current_day_in_loop->dayOfWeek) !== 'carrito vespertino') {
                    $tolerance = 135;
                }

                // calculate extras
                $extras_per_day = Carbon::parse($current_attendance[$i]['out'])
                    ->diffInMinutes($user->getEntryTime()[$i])
                    - $user->getTimeToWork()[$i];

                if (($extras_per_day - $tolerance) <= 0) $extras_per_day = 0;
                $extras += $extras_per_day;

                // late: serch for "permiso de llegada tarde" for this day
                $late_entry_permit = WorkPermit::whereDate('date', $current_day_in_loop)
                    ->where('user_id', $this->user_id)
                    ->where('permission_type_id', 1)
                    ->where('status', WorkPermit::STATUS_APPROVED)
                    ->first();
                $late_per_day = $user->getEntryTime()[$i]
                    ->diffInMinutes(Carbon::parse($current_attendance[$i]['in']), false);

                if ($late_entry_permit) $late_per_day -= $late_entry_permit->time_requested;
                // else $late_per_day -= 15;

                if (($late_per_day - 10) <= 0) $late_per_day = 0;
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
            'days_as_double' => $days_as_double,
            'double_commission_on' => $double_commission_on,
            'vacations' => $vacations,
            'extras' => $extras,
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

        return $work_days->doesntContain('day', $day_of_week);
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

    private function isHoliday(Carbon $date)
    {
        $is_holiday = Holiday::where('date', $date->isoFormat('DD-MM'))
            ->get()
            ->count();

        return $is_holiday;
    }

    public function paid()
    {
        $total = $this->baseSalary()
            + $this->vacationPremium()
            + collect($this->commissions())->sum()
            + $this->salaryForExtras()
            + $this->extraTime()['total_pay']
            + collect($this->bonuses())->sum('amount')
            - collect($this->discounts())->sum('amount');

        return round($total);
    }

    public function baseSalary()
    {
        // propoerty "additional" is not null when payroll is closed
        if ($this->additional) {
            // get stored data
            $week_attendance = $this->attendance;
            $base_salary = $this->additional['base_salary'];
        } else {
            // process data
            $week_attendance = $this->weekAttendanceArray();
            $base_salary = User::find($this->user_id)->employee_properties['base_salary'];
        }

        return ($week_attendance['attendances'] + $week_attendance['days_as_double'] + $week_attendance['vacations']) * $base_salary;
    }

    public function salaryForExtras()
    {
        if ($this->additional) {
            // get stored data
            $extras = $this->attendance['extras'];
        } else {
            // process data
            $extras = $this->weekAttendanceArray()['extras'];
        }

        $pesos_per_minute =  1;
        $salary_for_extras = $extras * $pesos_per_minute;

        return $salary_for_extras;
    }

    public function extraTime()
    {
        $total_pay = 0;
        $total_time = 0;
        // extra time
        if ($this->extras) {
            // get stored data
            foreach ($this->extras as $extra) {
                $total_pay += $extra['pay'];
                $total_time += $extra['time'];
            }
        }

        return compact('total_pay', 'total_time');
    }

    public function vacationPremium()
    {
        if ($this->additional) {
            // get stored data
            $vacation_days = $this->attendance['vacations'];
            $base_salary = $this->additional['base_salary'];
        } else {
            // process data
            $vacation_days = $this->weekAttendanceArray()['vacations'];
            $base_salary = User::find($this->user_id)->employee_properties['base_salary'];
        }

        return 0.25 * $base_salary * $vacation_days;
    }

    public function commissions()
    {
        if ($this->additional) {
            // get stored data
            return $this->additional['commissions'];
        } else {
            // process data
            $commissions = []; //refactor (repeated in closePayroll method)
            for ($i = 0; $i < 7; $i++) {
                $current_date = $this->payroll->start_date->addDays($i);
                $day_commission = Sale::calculateCommissions($current_date->toDateString());
                $commissions[$current_date->dayName] = $day_commission;
            }
            return $this->getCommissions($commissions);
        }
    }

    public function bonuses()
    {
        if ($this->additional) {
            // get stored data
            return array_key_exists('bonuses', $this->additional)
                ? $this->additional['bonuses']
                : [];
        } else {
            // process data
            return $this->user->getBonuses();
        }
    }

    public function getCommissions(array $commissions = [])
    {
        $current_payroll = Payroll::find($this->payroll_id);
        $user = User::find($this->user_id);
        $payroll_commissions = $commissions ?? $current_payroll->commissions;
        $user_commissions = [];

        for ($i = 0; $i < 7; $i++) {
            $current_day_in_loop = $current_payroll->start_date->addDays($i);
            $current_shift = $user->shiftOn($current_day_in_loop->dayOfWeek);

            if ($user->hasCheckedInOn($current_day_in_loop->dayOfWeek)) {
                if ($current_shift === 'carrito 2 turnos')
                    $user_commissions[] = $payroll_commissions[$current_day_in_loop->dayName] * 2;
                else
                    $user_commissions[] = $payroll_commissions[$current_day_in_loop->dayName];
            } else {
                $user_commissions[] = 0;
            }
        }

        return $user_commissions;
    }

    public function discounts()
    {
        if ($this->additional) {
            // get stored data
            return $this->discounts;
        } else {
            // process data
            return $this->getDiscounts();
        }
    }

    public function getDiscounts()
    {
        $user = User::find($this->user_id);
        $discounts = [];
        $base_salary = User::find($this->user_id)->employee_properties['base_salary'];
        $pesos_per_minute =  $base_salary / 360;

        // minutes late
        $minutes_late = $this->weekAttendanceArray()['late'];
        if ($minutes_late) {
            $discounts[] = [
                'amount' => round($minutes_late * $pesos_per_minute, 1),
                'description' => "$minutes_late minutos tarde en la semana"
            ];
        }

        // loans
        $loan = $user->activeLoan->first();
        if ($loan) {
            $pay = $loan->amount / 2;
            $discounts[] = [
                'amount' => round($pay, 2),
                'description' => "Abono de préstamo autorizado"
            ];
        }

        return $discounts;
    }
}
