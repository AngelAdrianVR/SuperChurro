<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission_types')->insert([
            [
            'name' => 'Llegada tarde',
            'is_full_day' => false,
            ],
            [
            'name' => 'Salida temprano',
            'is_full_day' => false,
            ],
            [
            'name' => 'Día de vacaiones',
            'is_full_day' => true,
            ],
            [
            'name' => 'Permiso sin goce',
            'is_full_day' => true,
            ],
        ]);
    }
}
