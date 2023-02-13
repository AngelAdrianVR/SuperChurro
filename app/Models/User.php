<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'is_active',
        'loan_active',
        'phone_number',
        'employee_properties',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'employee_properties' => 'array',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    //Relationships
    public function payrolls()
    {
        return $this->belongsToMany(Payroll::class)
            ->using(PayrollUser::class)
            ->withPivot(['id', 'attendance', 'discounts', 'additional'])
            ->withTimestamps();
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function activeLoan()
    {
        return $this->loans()->whereNotNull('authorized_at')->where('remaining', '>', 0);
    }

    public function workPermits()
    {
        return $this->hasMany(WorkPermit::class);
    }

    public function myBarters()
    {
        return $this->hasMany(Barter::class, 'transmitter_user_id');
    }

    public function aceptedBarters()
    {
        return $this->hasMany(Barter::class, 'receptor_user_id');
    }

    // methods
    public function getTimeToWork()
    {
        $time_to_work_array = [];

        foreach ($this->employee_properties['work_days'] as $work_day) {
            if ($work_day['shift'] === 'carrito vespertino') {
                $time_to_work = 360; // minutes (6 hours)
            } else if ($work_day['shift'] === 'carrito 2 turnos') {
                $time_to_work = 660; // minutes (11 hours)
            } else {
                $time_to_work =300; // minutes (5 hours)
            }
            $time_to_work_array[$work_day['day']] = $time_to_work;
        }

        return $time_to_work_array;
    }

    public function getEntryTime()
    {
        $entry_array = [];

        foreach ($this->employee_properties['work_days'] as $work_day) {
            if ($work_day['shift'] === 'carrito vespertino') {
                $entry = Carbon::parse('15:00:00');
            } else {
                $entry = Carbon::parse('10:00:00');
            }
            $entry_array[$work_day['day']] = $entry;
        }

        return $entry_array;
    }

    // public function getSalaryPerMinute()
    // {
    //     $salary_per_minute = $this->employee_properties['base_salary'] / $this->getTimeToWork();

    //     return round($salary_per_minute, 2);
    // }

    public function hasCheckedInToday()
    { //Remove this method and just keep hasCheckeInOn ***

        $current_payroll_id = Payroll::firstWhere('is_active', true)->id;

        $payroll_user = PayrollUser::firstOrNew([
            'payroll_id' => $current_payroll_id,
            'user_id' => $this->id
        ], ['attendance' => []]);

        return array_key_exists(today()->dayOfWeek, $payroll_user->attendance);
    }

    public function hasCheckedInOn($day_of_week)
    {

        $current_payroll_id = Payroll::firstWhere('is_active', true)->id;

        $payroll_user = PayrollUser::firstOrNew([
            'payroll_id' => $current_payroll_id,
            'user_id' => $this->id
        ], ['attendance' => []]);

        return array_key_exists($day_of_week, $payroll_user->attendance);
    }

    public function hasAttendanceOn($date)
    {
        $carbon_date = Carbon::parse($date);

        //find payroll active on date given
        $user_payroll = $this->payrolls
            ->firstWhere(function ($payroll) use ($carbon_date) {
                if ($carbon_date->dayOfWeek == 0) //sunday (new week in payroll)
                    return $payroll->week == $carbon_date->addDays(1)->weekOfYear;
                else
                    return $payroll->week == $carbon_date->weekOfYear;
            });

        // try to parse time to Carbon
        try {
            if ($user_payroll->is_active) {
                Carbon::parse($user_payroll->pivot->attendance[$carbon_date->dayOfWeek]['in']);
            } else {
                Carbon::parse($user_payroll->pivot->attendance['payroll'][$carbon_date->dayOfWeek]['in']);
            }
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function hasCheckedOutToday()
    {
        if (!$this->hasCheckedInToday()) return false;

        $current_payroll_id = Payroll::firstWhere('is_active', true)->id;

        $payroll_user = PayrollUser::firstOrNew([
            'payroll_id' => $current_payroll_id,
            'user_id' => $this->id
        ], ['attendance' => [today()->dayOfWeek => ['out' => '--:--:--']]]);

        return $payroll_user->attendance[today()->dayOfWeek]['out'] !== '--:--:--';
    }

    public function checkAttendance()
    {
        $current_payroll = Payroll::firstWhere('is_active', true);

        $payroll_user = PayrollUser::where('payroll_id', $current_payroll->id)
            ->where('user_id', $this->id)
            ->first();

        $today_attendance = ['in' => now()->toTimeString(), 'out' => '--:--:--', 'day' => today()->dayOfWeek];

        // isn't the first attendance in current payroll?
        if ($payroll_user) {
            $new_atendance = $payroll_user->attendance;

            if ($this->hasCheckedInToday()) {
                // checking out
                $new_atendance[today()->dayOfWeek]['out'] = now()->toTimeString();
            } else {
                // checking in
                $new_atendance[today()->dayOfWeek] = $today_attendance;
            }

            $payroll_user->update(['attendance' => $new_atendance]);
        } else {
            // creating payroll for auth user
            $this->payrolls()
                ->attach($current_payroll->id, [
                    'attendance' => [today()->dayOfWeek => $today_attendance]
                ]);

            // updating vacations (weekly)
            $this->updateVacations();
        }
    }

    public function shiftOn($day_of_week)
    {
        $work_days = collect($this->employee_properties['work_days']);
        $work_day = $work_days->firstWhere('day', $day_of_week);

        return $work_day ? $work_day['shift'] : null;
    }

    public function updateVacations()
    {
        $years_as_employee = $this->created_at->diffInYears();
        $employee_properties = $this->employee_properties;
        $days_per_year = 6;

        // if ($years_as_employee == 0) {
        //     $days_per_year = 12;
        // } elseif ($years_as_employee == 1) {
        //     $days_per_year = 14;
        // } elseif ($years_as_employee == 2) {
        //     $days_per_year = 16;
        // } elseif ($years_as_employee == 3) {
        //     $days_per_year = 18;
        // } elseif ($years_as_employee == 4) {
        //     $days_per_year = 20;
        // } elseif ($years_as_employee >= 6 && $years_as_employee < 11) {
        //     $days_per_year = 22;
        // } elseif ($years_as_employee >= 11 && $years_as_employee < 16) {
        //     $days_per_year = 24;
        // } elseif ($years_as_employee >= 16 && $years_as_employee < 21) {
        //     $days_per_year = 26;
        // } elseif ($years_as_employee >= 21 && $years_as_employee < 26) {
        //     $days_per_year = 28;
        // } elseif ($years_as_employee >= 26) {
        //     $days_per_year = 32;
        // }

        $days_per_week = $days_per_year / 52;
        $employee_properties['vacations'] += round($days_per_week, 3);
        $employee_properties['vacations_updated_date'] =
            Carbon::parse($employee_properties['vacations_updated_date'])->addDays(7)->toDateString();
        $this->update(['employee_properties' => $employee_properties]);
    }

    public function getBonuses()
    {
        $bonuses_ids = array_key_exists('bonuses', $this->employee_properties)
        ? $this->employee_properties['bonuses'] 
        : [];
        $detailed_bonuses = [];

        foreach($bonuses_ids as $id) {
            $current_bonus = Bonus::find($id);
            if($current_bonus->is_active) {
                $detailed_bonuses[] = ['name' => $current_bonus->name, 'amount' => $current_bonus->amount];
            }
        }

        return $detailed_bonuses;
    }
}
