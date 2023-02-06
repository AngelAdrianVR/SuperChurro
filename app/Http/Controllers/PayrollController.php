<?php

namespace App\Http\Controllers;

use App\Http\Resources\PayrollResource;
use App\Http\Resources\PayrollUserResource;
use App\Http\Resources\PayrollUserResource2;
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
        $payrolls = PayrollUserResource::collection(auth()->user()->payrolls()->orderBy('id', 'desc')->get());

        return Inertia::render('PayRoll/Index', compact('payrolls'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Payroll $payroll)
    {
        //
    }

    public function edit(Payroll $payroll)
    {
        //
    }

    public function update(Request $request, Payroll $payroll)
    {
        //
    }

    public function destroy(Payroll $payroll)
    {
        //
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

        // create new payroll
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
                    'commissions' => $user_payroll->pivot->getCommissions($commissions)
                ]
            ]);
        });

        // store commissions & close payroll
        $active_payroll->update([
            'commissions' => $commissions,
            'is_active' => false,
        ]);
    }
}
