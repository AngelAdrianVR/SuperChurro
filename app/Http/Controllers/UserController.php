<?php

namespace App\Http\Controllers;

use App\Http\Resources\PayrollResource;
use App\Http\Resources\UserResource;
use App\Models\Bonus;
use App\Models\Payroll;
use App\Models\PayrollUser;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = UserResource::collection(User::where('id', '!=', auth()->id())->get());

        return inertia('User/Index', compact('users'));
    }

    public function create()
    {
        $bonuses = Bonus::all();

        return inertia('User/Create', compact('bonuses'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'email',
            'phone_number' => 'required|numeric|digits:10',
            'employee_properties.birthdate' => 'required|date',
            'employee_properties.base_salary' => 'required|numeric',
            'employee_properties.work_days' => 'required',
            'employee_properties.vacations' => 'max:30',
            'employee_properties.vacations_updated_date' => 'string',
            'employee_properties.bonuses' => 'nullable',
        ]);

        $user = User::create($validated + [
            'password' => bcrypt('123'),

        ]);

        $user->addAllMediaFromRequest()->each(fn ($file) => $file->toMediaCollection());

        request()->session()->flash('flash.banner', '¡Se ha creado un nuevo usuario correctamente!');
        request()->session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('users.index');
    }

    public function show(User $user)
    {
        $media = $user->getMedia()->all();
        $bonuses = Bonus::all();

        return inertia('User/Show', compact('user', 'media', 'bonuses'));
    }

    public function edit(User $user)
    {
        //
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'email',
            'phone_number' => 'required|numeric|digits:10',
            'employee_properties.birthdate' => 'required|date',
            'employee_properties.base_salary' => 'required|numeric',
            'employee_properties.work_days' => 'required',
            'employee_properties.vacations' => 'max:30',
            'employee_properties.vacations_updated_date' => 'min:1',
            'employee_properties.bonuses' => 'nullable',
        ]);

        $user->update($validated);
        $user->addAllMediaFromRequest()->each(fn ($file) => $file->toMediaCollection());

        request()->session()->flash('flash.banner', '¡Se ha actualizado la información del usuario!');
        request()->session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('users.index');
    }

    public function updateWithResources(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'email',
            'phone_number' => 'required|numeric|digits:10',
            'employee_properties.birthdate' => 'required|date',
            'employee_properties.base_salary' => 'required|numeric',
            'employee_properties.work_days' => 'required',
            'employee_properties.vacations' => 'max:30',
            'employee_properties.vacations_updated_date' => 'min:1',
        ]);

        $user->update($validated);
        $user->addAllMediaFromRequest()->each(fn ($file) => $file->toMediaCollection());

        request()->session()->flash('flash.banner', '¡Se ha actualizado la información del usuario!');
        request()->session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        //
    }

    public function disable(User $user)
    {
        $user->is_active = false;
        $user->save();

        request()->session()->flash('flash.banner', '¡Se ha dado de baja al usuario correctamente!');
        request()->session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('users.index');
    }

    public function enable(User $user)
    {
        $user->is_active = true;
        $user->save();

        request()->session()->flash('flash.banner', '¡Se ha dado de alta al usuario correctamente!');
        request()->session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('users.index');
    }

    public function resetPass(User $user)
    {
        $user->password = bcrypt('12345678');
        $user->save();

        request()->session()->flash('flash.banner', '¡Se ha dado reseteado la contraseña a 12345678!');
        request()->session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('users.index');
    }

    public function deleteFile(Request $request)
    {
        User::find($request->user_id)->deleteMedia($request->file_id);

        return response()->json(['success' => 'success'], 200);
    }

    public function showUsersCrhismasBonus(User $user)
    {
        $current_year = now()->year;
        $initial_date = Carbon::createMidnightDate($current_year, 1, 1);
        $worked_days = $initial_date->diffInDays(now()->addDays(15));
        $work_days_per_week = count($user->employee_properties['work_days']);
        $base_salary = $user->employee_properties['base_salary'];
        $month_salary = $work_days_per_week * $base_salary * 4;
        $daily_salary = $month_salary / 30;
        $bonus_days = ($worked_days * 15) / 365;
        $chrismas_bonus = number_format($bonus_days * $daily_salary);


        return inertia('User/Calculations/ChrismasBonusTemplate', compact('user', 'chrismas_bonus'));
    }

    public function showUserSettlement(User $user)
    {

        $current_year = now()->year;
        $initial_date = Carbon::createMidnightDate($current_year, 1, 1);
        $worked_days = $initial_date->diffInDays(now());
        $work_days_per_week = count($user->employee_properties['work_days']);
        $base_salary = $user->employee_properties['base_salary'];
        $month_salary = $work_days_per_week * $base_salary * 4;
        $daily_salary = $month_salary / 30;
        $bonus_days = ($worked_days * 15) / 365;
        $chrismas_bonus = round($bonus_days * $daily_salary);
        $proporcional_vacations = $user->employee_properties['vacations'] * $base_salary;
        $vacation_bonus =  $user->employee_properties['vacations'] * $base_salary * 0.25;
        $settlement = round($proporcional_vacations + $vacation_bonus + $chrismas_bonus);

        return inertia('User/Calculations/SettlementTemplate', compact('user', 'chrismas_bonus', 'month_salary', 'proporcional_vacations', 'vacation_bonus', 'settlement'));
    }

    public function showUserVacationBonus(User $user)
    {

        $years_as_employee = $user->created_at->diffInYears();
        $employee_properties = $user->employee_properties;
        $days_per_year = 0;

        if ($years_as_employee == 0) {
            $days_per_year = 12;
        } elseif ($years_as_employee == 1) {
            $days_per_year = 14;
        } elseif ($years_as_employee == 2) {
            $days_per_year = 16;
        } elseif ($years_as_employee == 3) {
            $days_per_year = 18;
        } elseif ($years_as_employee == 4) {
            $days_per_year = 20;
        } elseif ($years_as_employee >= 6 && $years_as_employee < 11) {
            $days_per_year = 22;
        } elseif ($years_as_employee >= 11 && $years_as_employee < 16) {
            $days_per_year = 24;
        } elseif ($years_as_employee >= 16 && $years_as_employee < 21) {
            $days_per_year = 26;
        } elseif ($years_as_employee >= 21 && $years_as_employee < 26) {
            $days_per_year = 28;
        } elseif ($years_as_employee >= 26) {
            $days_per_year = 32;
        }

        $base_salary = $user->employee_properties['base_salary'];
        $vacation_bonus =  number_format(($days_per_year - $user->employee_properties['vacations']) * $base_salary * 0.25);

        return inertia('User/Calculations/VacationBonusTemplate', compact('user', 'vacation_bonus', 'days_per_year'));
    }

    public function payVacations(Request $request)
    {
        $request->validate([
            'vacation_days' => 'required|numeric|min:1'
        ]);

        $payroll_user = PayrollUser::where('user_id', $request->user_id)->latest()->first();
        $extras = $payroll_user->extras ?? [];
        $extras['vacations'] = $request->vacation_days;
        $payroll_user->update(['extras' => $extras]);
        $user = User::find($request->user_id);
        $employee_properties = $user->employee_properties;
        $employee_properties['vacations'] = 0;
        $user->update(compact('employee_properties'));

        return response()->json(['message' => 'Vacaciones agregadas a nomina']);
    }

    public function generatePayroll($user_id)
    {
        $user = User::find($user_id);
        $user->checkAttendance();
        $payroll = Payroll::with('users')->latest()->first();

        return response()->json(['payroll' => PayrollResource::make($payroll)]);
    }
}
