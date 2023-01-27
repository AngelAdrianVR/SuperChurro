<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Payroll;
use App\Models\PermissionType;
use App\Models\WarehouseMovement;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Payroll::create([
            'week' => today()->addDays(1)->weekOfYear,
            'start_date' => today()->subDays(today()->dayOfWeek)->toDateString(),
            'is_active' => 1,
        ]);

        $this->call([
            UserSeeder::class,
            CartSeeder::class,
            MovementConceptSeeder::class,
            PermissionTypeSeeder::class,
            UnitsSeeder::class,
            WarehouseSeeder::class,
            ProductSeeder::class,
            PriceSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
