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
        $current_payroll = Payroll::latest()->take(1)->get()->all()[0];
        for ($i = 0; $i < 7; $i ++) { 
            if(!array_key_exists($i, $current_attendance)) {
                // check if this day is off, applied leave or holyday
                $current_attendance[$i] = $this->typeOfAbsent($current_payroll->start_date->addDays($i));
            }
        }
        return $current_attendance;
    }

    private function typeOfAbsent($date)
    {
        if($this->isDayOff($date->dayOfWeek)) return "Día de descanso";
        if($this->isVacation($date)) return "Vacaciones";
        if($this->isLeave($date)) return "Permiso aprobado";
        // if($this->isHollyday($date)) return "Día feriado";
        if($date->greaterThanOrEqualTo(now())) "Sin información";
        return "Falta";
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

    // private function isHoliday($date)
    // {
    //     $is_holiday = Holiday::whereDate('date', $date)
    //         ->get()
    //         ->count();

    //     return $is_holiday;
    // }
}
