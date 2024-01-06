<?php

namespace App\Http\Controllers;

use App\Http\Resources\PayrollResource;
use App\Http\Resources\PayrollUserResource;
use App\Models\Payroll;
use App\Models\PayrollUser;
use App\Models\User;
use App\Models\WorkPermit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PayrollController extends Controller
{
    public function index()
    {
        $payrolls = PayrollUserResource::collection(auth()->user()->payrolls()->orderBy('id', 'desc')->get()->take(4));

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
        $payrolls = PayrollResource::collection(Payroll::with('users')
            ->whereMonth('start_date', today())
            ->whereYear('start_date', today())
            ->latest()
            ->get());

        $usersWithNoAttendance = $this->getUsersWithNoAttendance($payrolls);

        return inertia('PayRoll/Admin/Index', compact('payrolls', 'usersWithNoAttendance'));
    }

    public function getByDate($date)
    {
        $carbonDate = Carbon::parse($date);
        $payrolls = PayrollResource::collection(Payroll::with('users')
            ->whereMonth('start_date', $carbonDate)
            ->whereYear('start_date', $carbonDate)
            ->latest()
            ->get());

        $usersWithNoAttendance = $this->getUsersWithNoAttendance($payrolls);

        return response()->json(['items' => $payrolls, 'usersWithNoAttendance' => $usersWithNoAttendance]);
    }

    public function getUsersWithNoAttendance($payrolls)
    {
        $usersWithNoAttendance = [];

        if ($payrolls->all()) {
            $currentPayrollId = $payrolls[0]->id; // ID de la nómina en curso

            $usersWithNoAttendance = User::whereDoesntHave('payrolls', function ($query) use ($currentPayrollId) {
                $query->where('payroll_id', $currentPayrollId);
            })->where('is_active', true)->whereNotIn('id', [1, 3])->get();
        }
        return $usersWithNoAttendance;
    }

    public function showUsersPayrolls($ids, $payroll_id)
    {
        $ids = json_decode($ids);

        $payroll = Payroll::with('users')->find($payroll_id);

        // Filtrar los usuarios en base a los IDs proporcionados
        $filteredUsers = $payroll->users->filter(function ($user) use ($ids) {
            return in_array($user->id, $ids);
        });

        // Convertir la colección filtrada a un array de objetos
        $filteredUsersArray = $filteredUsers->values()->all();

        // Asignar el array de usuarios filtrados de nuevo al objeto $payroll
        $payroll->users = $filteredUsersArray;

        // Crear el recurso PayrollResource
        $payroll = PayrollResource::make($payroll);

        return inertia('PayRoll/Admin/Receipt', compact('payroll'));
    }

    // public function closePayroll()
    // {
    //     $active_payroll = Payroll::where('is_active', true)->first();

    //     //create new payroll
    //     Payroll::create([
    //         'week' => $active_payroll->start_date->addDays(8)->weekOfYear,
    //         'start_date' => $active_payroll->start_date->addDays(7)->toDateString(),
    //     ]);

    //     // get commissions of each day of week
    //     $commissions = [];
    //     for ($i = 0; $i < 7; $i++) {
    //         $current_date = $active_payroll->start_date->addDays($i);
    //         $day_commission = Sale::calculateCommissions($current_date->toDateString());
    //         $commissions[$current_date->dayName] = $day_commission;
    //     }

    //     // store discounts, additional & attendance info for each user payroll
    //     $active_payroll->users->each(function ($user_payroll) use ($commissions) {
    //         $user_payroll->pivot->update([
    //             'discounts' => $user_payroll->pivot->getDiscounts(),
    //             'attendance' => $user_payroll->pivot->weekAttendanceArray(),
    //             'additional' => [
    //                 'base_salary' => User::find($user_payroll->pivot->user_id)->employee_properties['base_salary'],
    //                 'commissions' => $user_payroll->pivot->getCommissions($commissions),
    //                 'bonuses' => $user_payroll->getBonuses()
    //             ]
    //         ]);

    //         // decrement loan's amount if exists an active one
    //         $loan = $user_payroll->activeLoan?->first();
    //         $loan?->decrement('remaining', round($loan?->amount / 2, 2));
    //     });

    //     // store commissions & close payroll
    //     $active_payroll->update([
    //         'commissions' => $commissions,
    //         'is_active' => false,
    //     ]);

    //     // calculate total salary
    //     $total_salaries = $active_payroll->users->reduce(function ($carry, $item) {
    //         return $carry + $item->pivot->paid();
    //     });

    //     // create outcome for all salaries
    //     Outcome::create([
    //         'concept' => 'Salarios',
    //         'quantity' => 1,
    //         'cost' => $total_salaries,
    //         'notes' => 'Generado automaticamente al cerrar las nominas',
    //         'user_id' => auth()->id(),
    //     ]);

    //     // create outcome for rent if date 
    //     $fechaActual = now();
    //     // Obtén el quinto día del mes actual
    //     $quintoDiaDelMes = now()->startOfMonth()->addDays(4);
    //     $rentOutcome = Outcome::whereDate('created_at', $quintoDiaDelMes)->where('concept', 'Renta carrito')->first();

    //     if (!$rentOutcome) {
    //         // Compara las fechas
    //         if ($fechaActual->gte($quintoDiaDelMes)) {
    //             Outcome::create([
    //                 'concept' => 'Renta carrito',
    //                 'quantity' => 1,
    //                 'cost' => 37910,
    //                 'notes' => 'Generado automaticamente',
    //                 'user_id' => auth()->id(),
    //                 'created_at' => $quintoDiaDelMes
    //             ]);
    //         }
    //     }
    // }

    public function updatePayroll(Request $request)
    {
        $payroll_user = PayrollUser::find($request->payroll_user_id);

        $attendance = $payroll_user->attendance;

        // create new attendance day
        $attendance[$request->day] = [
            'in' => $request->attendance['in'],
            'out' => $request->attendance['out'],
            'day' => $request->day,
        ];

        $payroll_user->update(['attendance' => $attendance]);
    }

    public function removeAbsent(Request $request)
    {
        $payroll_user = PayrollUser::find($request->payroll_user_id);

        $attendance = $payroll_user->attendance;

        // create new attendance day
        $attendance[$request->day] = [
            'in' => "10:00",
            'out' => "10:01",
            'day' => $request->day,
        ];

        $payroll_user->update(['attendance' => $attendance]);
    }

    public function setIncident(Request $request)
    {
        $payroll_user = PayrollUser::find($request->payroll_user_id);
        $create_incident = true;
        $notificaion['title'] = "Correcto";
        $notificaion['message'] = "Se ha registrado la incidencia";
        $notificaion['type']  = "success";

        // incidente 3 es vacaciones
        if ($request->incident_id == 3 && $payroll_user->user->employee_properties['vacations'] < 1) {
            $create_incident = false;
            $notificaion['title'] = "Atención";
            $notificaion['message'] = "No se pudo registrar el día de vacaciones debido a que el empleado no cuenta con días disponibles";
            $notificaion['type']  = "info";
        } else if ($request->incident_id == 3) {
            $ep = $payroll_user->user->employee_properties;
            $ep['vacations']--;
            $payroll_user->user()->update(['employee_properties' => $ep]);
        }

        // crear permiso o incidencia
        if ($create_incident) {
            $date = $payroll_user->payroll->start_date->addDays($request->day)->toDateString();
            $user_id = $payroll_user->user->id;

            WorkPermit::updateOrCreate(
                [
                    'date' => $date,
                    'user_id' => $user_id,
                ],
                [
                    'permission_type_id' => $request->incident_id,
                    'status' => 2,
                ]
            );
        }

        return response()->json(['notification' => $notificaion]);
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
