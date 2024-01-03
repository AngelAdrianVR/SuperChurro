<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\Outcome;
use App\Models\Sale;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $checked_in = auth()->user()->hasCheckedInToday();
        $checked_out = auth()->user()->hasCheckedOutToday();
        $loan = auth()->user()->loans()->where('remaining', '>', 0)->whereNotNull('authorized_at')->first();
        $leaves = auth()->user()->workPermits()->whereDate('date', '>=', today())->with('permissionType')->get();
        $notices = Notice::all();

        $collaborators_birthdays = User::where('is_active', true)->whereMonth('employee_properties->birthdate', '=', today()->month)
            ->get();

        $salesCurrentYear = $this->getMonthlySum(Sale::whereYear('created_at', today())->get(['quantity', 'price', 'created_at']), 'sales');
        $outcomesCurrentYear = $this->getMonthlySum(Outcome::whereYear('created_at', today())->get(['quantity', 'cost', 'created_at']), 'outcomes');
        $salesLastYear = $this->getMonthlySum(Sale::whereYear('created_at', today()->subYear())->get(['quantity', 'price', 'created_at']), 'sales');
        $outcomesLastYear = $this->getMonthlySum(Outcome::whereYear('created_at', today()->subYear())->get(['quantity', 'cost', 'created_at']), 'outcomes');

        return auth()->user()->is_admin
            ? inertia(
                'AdminDashboard',
                compact('notices', 'collaborators_birthdays', 'salesCurrentYear', 'outcomesCurrentYear', 'salesLastYear', 'outcomesLastYear')
            )
            : inertia('Dashboard', compact('checked_in', 'checked_out', 'loan', 'leaves', 'notices'));
    }

    private function getMonthlySum($items, $type = 'sales')
    {
        // Inicializa un array asociativo para almacenar la suma del monto por mes
        $monthlySumMap = [];

        // Crea un array con los nombres cortos de los meses
        $monthsOrder = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

        // Inicializa el array con todas las entradas para cada mes
        foreach ($monthsOrder as $month) {
            $monthlySumMap[$month] = ['month' => $month, 'amount' => 0];
        }

        // Itera sobre las ventas y agrega el monto al mes correspondiente
        foreach ($items as $item) {
            $created_at = new DateTime($item->created_at);
            $month = intval($created_at->format('m')) - 1;

            // Verifica si la propiedad 'price' y 'quantity' existe en el objeto antes de sumar
            if ($type == 'sales' && isset($monthlySumMap[$monthsOrder[$month]]) && is_numeric($item->price)) {
                // Suma el price al monto existente
                $monthlySumMap[$monthsOrder[$month]]['amount'] += ($item->price * $item->quantity) / 1000;
            } elseif (isset($monthlySumMap[$monthsOrder[$month]]) && !is_null($item->cost) && is_numeric($item->cost)) {
                // Suma el cost al monto existente
                $monthlySumMap[$monthsOrder[$month]]['amount'] += ($item->cost * $item->quantity) / 1000;
            }
        }

        // Ordena el array por el nombre del mes
        uasort($monthlySumMap, function ($a, $b) use ($monthsOrder) {
            return array_search($a['month'], $monthsOrder) - array_search($b['month'], $monthsOrder);
        });

        // Devuelve el array resultante
        return array_values($monthlySumMap);
    }
}
