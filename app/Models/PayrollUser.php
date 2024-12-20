<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PayrollUser extends Pivot
{
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
        $paid_leaves = 0;
        $no_paid_leaves = 0;
        $sickness = 0;
        $holidays = 0;
        $extras = 0; // minutes
        $late = 0; // minutes
        $tolerance = 0;
        $days_late_number = []; //id of days where employee was late

        for ($i = 0; $i < 7; $i++) {
            $current_day_in_loop = $current_payroll->start_date->addDays($i);
            if (!array_key_exists($i, $current_attendance ?? [])) {
                // check if this day is off, applied leave or holyday
                $current_attendance[$i] = $this->typeOfAbsent($current_day_in_loop);

                // add incidents & sub attendances
                if ($current_attendance[$i]['in'] == 'Día feriado') {
                    // doble paga si colaborador trabaja 2 turnos el dia feriado
                    if ($user->shiftOn($current_day_in_loop->dayOfWeek) === 'carrito 2 turnos') {
                        $holidays += 2;
                    } else {
                        $holidays++;
                    }
                } elseif ($current_attendance[$i]['in'] == 'Vacaciones') $vacations++;
                elseif ($current_attendance[$i]['in'] == 'Permiso con goce') $paid_leaves++;
                elseif ($current_attendance[$i]['in'] == 'Permiso sin goce') $no_paid_leaves++;
                elseif ($current_attendance[$i]['in'] == 'Incapacidad') $sickness++;
                $attendances--;
            } else if ($current_attendance[$i]['out'] !== '--:--:--') { // si trabajó el colaborador
                // colaborador trabajó en día feriado
                if ($this->isHoliday($current_day_in_loop)) {
                    if ($user->shiftOn($current_day_in_loop->dayOfWeek) == 'carrito 2 turnos') {
                        // se dan 5 turnos adicionales si se trabaja todo el dia en dia feriado
                        $days_as_double += 5;
                    } else {
                        // se dan 2 turnos adicionales si se trabaja 1 turno en dia feriado
                        $days_as_double += 2;
                    }
                    $double_commission_on[] = $i;
                } else { //no es dia feriado
                    if ($user->shiftOn($current_day_in_loop->dayOfWeek) == 'carrito 2 turnos') {
                        // sumar 1 turno adicional si trabaja 2 turnos 
                        $days_as_double += 1;
                    }
                    $double_commission_on[] = $i;
                }
                // if ($user->shiftOn($current_day_in_loop->dayOfWeek) == 'carrito 2 turnos' || $this->isHoliday($current_day_in_loop)) {
                //     if ($user->shiftOn($current_day_in_loop->dayOfWeek) == 'carrito 2 turnos' && $this->isHoliday($current_day_in_loop)) {
                //         // se da el doble si se trabaja todo el dia en dia feriado
                //         $days_as_double += 3;
                //     } else {
                //         $days_as_double++;
                //     }
                //     $double_commission_on[] = $i;
                // }
                // else if ($user->shiftOn($current_day_in_loop->dayOfWeek) !== 'carrito vespertino') {
                //     $tolerance = 135;
                // }

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

                if ($late_per_day <= 0) {
                    $late_per_day = 0;
                } else {
                    $days_late_number[] = $i;
                }

                $late += $late_per_day;

                // calcular extras 
                $current_shift = $user->shiftOn($current_day_in_loop->dayOfWeek);
                if ($current_shift == 'carrito vespertino' || $current_shift == 'carrito 2 turnos') {
                    $extras_per_day = Carbon::parse($current_attendance[$i]['out'])
                        ->diffInMinutes($current_attendance[$i]['in'])
                        - $user->getTimeToWork()[$i];

                    if ($extras_per_day <= 0) {
                        $extras_per_day = 0;
                    } else {
                        $extras += $extras_per_day;
                    }
                }
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
            'paid_leaves' => $paid_leaves,
            'no_paid_leaves' => $no_paid_leaves,
            'sickness' => $sickness,
            'holidays' => $holidays,
            'extras' => $extras,
            'late' => $late,
            'days_late_number' => $days_late_number,
        ];
    }

    private function typeOfAbsent($date)
    {
        if ($this->isDayOff($date->dayOfWeek)) $absent_type = "Día de descanso";
        else if ($this->isHoliday($date)) $absent_type = "Día feriado";
        else if ($this->getApprovedIncident($date)) $absent_type = $this->getApprovedIncident($date);
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

    private function getApprovedIncident($date)
    {
        $incident = WorkPermit::where('user_id', $this->user_id)
            ->whereDate('date', $date)
            ->where('status', WorkPermit::STATUS_APPROVED)
            ->first();

        return $incident?->permissionType?->name;
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
            + collect($this->commissions())->sum()
            + $this->salaryForExtras()
            + $this->extraTime()['total_pay']
            + collect($this->bonuses())->sum('amount')
            - collect($this->discounts())->sum('amount')
            + $this->payVacations()
            + $this->payLeaves()
            + $this->payHoliday()
            + $this->paySickness();

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

        return ($week_attendance['attendances'] + $week_attendance['days_as_double']) * $base_salary;
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
            // get storeddata
            foreach ($this->extras as $extra) {
                $total_pay += $extra['pay'];
                $total_time += $extra['time'];
            }
        }

        return compact('total_pay', 'total_time');
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
        $pesos_per_minute =  1;

        // minutes late
        // $minutes_late = $this->weekAttendanceArray()['late'];
        // if ($minutes_late) {
        //     $discounts[] = [
        //         'amount' => round($minutes_late * $pesos_per_minute, 1),
        //         'description' => "$minutes_late minutos tarde en la semana"
        //     ];
        // }

        // loans
        $loan = $user->activeLoan->first();
        if ($loan) {
            $pay = $loan->amount / 2;
            $discounts[] = [
                'amount' => round($pay, 2),
                'description' => "Abono de préstamo"
            ];
        }

        return $discounts;
    }

    // public function payVacations()
    // {
    //     $user = User::find($this->user_id);

    //     if (isset($this->extras['vacations'])) {
    //         return $this->extras['vacations'] * $user->employee_properties['base_salary'];
    //     } else {
    //         return 0;
    //     }
    // }

    public function payVacations()
    {
        if ($this->additional) {
            if (!key_exists('vacations', $this->attendance)) return 0;
            // get stored data
            $vacation_days = $this->attendance['vacations'];
            $base_salary = $this->additional['base_salary'];
        } else {
            // process data
            $vacation_days = $this->weekAttendanceArray()['vacations'];
            $base_salary = User::find($this->user_id)->employee_properties['base_salary'];
        }

        return 1.25 * $base_salary * $vacation_days;
    }

    public function payHoliday()
    {
        if ($this->additional) {
            if (!key_exists('holidays', $this->attendance)) return 0;
            // get stored data
            $holidays = $this->attendance['holidays'];
            $base_salary = $this->additional['base_salary'];
        } else {
            // process data
            $holidays = $this->weekAttendanceArray()['holidays'];
            $base_salary = User::find($this->user_id)->employee_properties['base_salary'];
        }

        return $base_salary * $holidays;
    }

    public function payLeaves()
    {
        if ($this->additional) {
            if (!key_exists('paid_leaves', $this->attendance)) return 0;
            // get stored data
            $leaves = $this->attendance['paid_leaves'];
            $base_salary = $this->additional['base_salary'];
        } else {
            // process data
            $leaves = $this->weekAttendanceArray()['paid_leaves'];
            $base_salary = User::find($this->user_id)->employee_properties['base_salary'];
        }

        return $base_salary * $leaves;
    }

    public function paySickness()
    {
        if ($this->additional) {
            if (!key_exists('sickness', $this->attendance)) return 0;
            // get stored data
            $sickness = $this->attendance['sickness'];
            $base_salary = $this->additional['base_salary'];
        } else {
            // process data
            $sickness = $this->weekAttendanceArray()['sickness'];
            $base_salary = User::find($this->user_id)->employee_properties['base_salary'];
        }

        return $base_salary * $sickness * 0.6;
    }
}
