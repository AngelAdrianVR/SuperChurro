<?php

namespace App\Console\Commands;

use App\Models\Outcome;
use App\Models\Payroll;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ClosePayrollCommand extends Command
{
    protected $signature = 'app:close-payroll';
    protected $description = 'Close current payroll and create a new one';

    public function handle()
    {
        $current = Payroll::latest()->first();
        Payroll::create([
            'start_date' => $current->start_date->addDays(7)->toDateString(),
            'week' => $current->start_date->addDays(8)->weekOfYear,
        ]);

        // get commissions of each day of week
        $commissions = [];
        for ($i = 0; $i < 7; $i++) {
            $current_date = $current->start_date->addDays($i);
            $day_commission = Sale::calculateCommissions($current_date->toDateString());
            $commissions[$current_date->dayName] = $day_commission;
        }

        // store discounts, additional & attendance info for each user payroll
        $current->users->each(function ($user_payroll) use ($commissions) {
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
            if ($loan) {
                $half = $loan->amount / 2;
                $remaining = round($half, 2);
                $loan->decrement('remaining', $remaining);
            }
        });

        // store commissions & close payroll
        $current->update([
            'commissions' => $commissions,
            'is_active' => false,
        ]);

        // calculate total salary
        $total_salaries = $current->users->reduce(function ($carry, $item) {
            return $carry + $item->pivot->paid();
        });

        // create outcome for all salaries
        Outcome::create([
            'concept' => 'Sueldos',
            'quantity' => 1,
            'category' => 'Gastos administrativos',
            'cost' => $total_salaries,
            'notes' => 'Generado automaticamente al cerrar las nóminas',
            'user_id' => auth()->id(),
            'category' => 'Gastos administrativos',
            'date' => now()->toDateString(),
            'provider' => 'Administración',
            'payment_method' => 'Efectivo',
        ]);

        // create outcome for rent if date 
        $fechaActual = now();
        // Obtén el quinto día del mes actual
        $quintoDiaDelMes = now()->startOfMonth()->addDays(4);
        $rentOutcome = Outcome::whereDate('created_at', $quintoDiaDelMes)->where('concept', 'Renta carrito')->first();

        if (!$rentOutcome) {
            // Compara las fechas
            if ($fechaActual->gte($quintoDiaDelMes)) {
                Outcome::create([
                    'concept' => 'Renta carrito',
                    'quantity' => 1,
                    'cost' => 40800,
                    'notes' => 'Generado automaticamente',
                    'user_id' => auth()->id(),
                    'category' => 'Gastos administrativos',
                    'date' => now()->toDateString(),
                    'provider' => 'Administración',
                    'payment_method' => 'Efectivo',
                    'created_at' => $quintoDiaDelMes
                ]);
            }
        }

        Log::info('app:close-payroll executed successfully.');
    }
}
