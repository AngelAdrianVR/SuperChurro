<?php

namespace App\Console\Commands;

use App\Models\Payroll;
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
            'week' => today()->weekOfYear + 1,
        ]);

        $current->update(['is_active' => 0]);

        Log::info('app:increase-product-price executed successfully.');
    }
}
