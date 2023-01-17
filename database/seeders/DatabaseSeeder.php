<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

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
