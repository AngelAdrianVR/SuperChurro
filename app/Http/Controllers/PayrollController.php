<?php

namespace App\Http\Controllers;

use App\Http\Resources\PayrollResource;
use App\Http\Resources\PayrollUserResource;
use App\Http\Resources\PayrollUserResource2;
use App\Models\Outcome;
use App\Models\Payroll;
use App\Models\PayrollUser;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PayrollController extends Controller
{

    public function index()
    {
        $payrolls = PayrollUserResource::collection(auth()->user()->payrolls()->orderBy('id', 'desc')->get()->take(8));

        return Inertia::render('PayRoll/Index', compact('payrolls'));
    }

    public function storeAttendance()
    {
        auth()->user()->checkAttendance();

        return to_route('dashboard');
    }

    // admin
    public function adminIndex()
    {
        $payrolls = PayrollResource::collection(Payroll::with('users')->latest()->get());

        return inertia('PayRoll/Admin/Index', compact('payrolls'));
    }

    public function showUsersPayrolls($payroll_id)
    {
        $payroll = PayrollResource::make(Payroll::with('users')->find($payroll_id));

        return inertia('PayRoll/Admin/Template', compact('payroll'));
    }

    public function showUserPayroll($payroll_user_id) // refactor (open same template of showUsersPayrolls method)
    {
        $payroll_user = PayrollUserResource2::make(PayrollUser::with('payroll', 'user')->find($payroll_user_id));

        return inertia('PayRoll/Admin/Template2', compact('payroll_user'));
    }

    public function closePayroll()
    {
        $active_payroll = Payroll::where('is_active', true)->first();

        //create new payroll
        Payroll::create([
            'week' => $active_payroll->start_date->addDays(8)->weekOfYear,
            'start_date' => $active_payroll->start_date->addDays(7)->toDateString(),
        ]);

        // get commissions of each day of week
        $commissions = [];
        for ($i = 0; $i < 7; $i++) {
            $current_date = $active_payroll->start_date->addDays($i);
            $day_commission = Sale::calculateCommissions($current_date->toDateString());
            $commissions[$current_date->dayName] = $day_commission;
        }

        // store discounts, additional & attendance info for each user payroll
        $active_payroll->users->each(function ($user_payroll) use ($commissions) {
            $user_payroll->pivot->update([
                'discounts' => $user_payroll->pivot->getDiscounts(),
                'attendance' => $user_payroll->pivot->weekAttendanceArray(),
                'additional' => [
                    'base_salary' => User::find($user_payroll->pivot->user_id)->employee_properties['base_salary'],
                    'commissions' => $user_payroll->pivot->getCommissions($commissions),
                    'bonuses' => $user_payroll->getBonuses()
                ]
            ]);

            // decrement loan's amount if exists an active one
            $loan = $user_payroll->activeLoan?->first();
            $loan?->decrement('remaining', round($loan?->amount / 2, 2));
        });

        // store commissions & close payroll
        $active_payroll->update([
            'commissions' => $commissions,
            'is_active' => false,
        ]);

        // calculate total salary
        $total_salaries = $active_payroll->users->reduce(function ($carry, $item) {
            return $carry + $item->pivot->paid();
        });
        
        // create outcome for all salaries
        Outcome::create([
            'concept' => 'Salarios',
            'quantity' => 1,
            'cost' => $total_salaries,
            'notes' => 'Generado automaticamente al cerrar las nominas',
            'user_id' => auth()->id(),
        ]);
    }

    public function updatePayroll(Request $request)
    {
        $payroll_user = PayrollUser::find($request->payroll_user_id);
        $is_absent = true;

        $attendance = $payroll_user->attendance;
        foreach ($attendance as $key => $record) {
            if ($record['day'] == $request->day) {
                if ($request->attendance['in'] && strtolower($request->attendance['in']) != 'falta') {
                    $attendance[$key]['in'] = $request->attendance['in'];
                    $attendance[$key]['out'] = $request->attendance['out'];
                    $is_absent = false;
                    break;
                } else {
                    unset($attendance[$key]);
                    $is_absent = false;
                }
            }
        }
        // it was an absent: create new attendance day
        if ($is_absent && $request->attendance['in'] && strtolower($request->attendance['in']) != 'falta') {
            $attendance[$request->day] = [
                'in' => $request->attendance['in'],
                'out' => $request->attendance['out'],
                'day' => $request->day,
            ];
        }

        $payroll_user->update(['attendance' => $attendance]);
    }

    public function storeExtras(Request $request)
    {
        $week_days = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
        $payroll_user = PayrollUser::find($request->payroll_user_id);
        $extras = $payroll_user->extras;
        $add_extras = ['time' => $request->time, 'pay' => $request->pay];

        if ($extras)
            $extras[$week_days[$request->week_day]] = $add_extras;
        else
            $extras[$week_days[$request->week_day]] = $add_extras;

        $payroll_user->extras = $extras;
        $payroll_user->save();

        // return response()->json(['extras' => $extras]);
    }
}
