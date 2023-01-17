<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            [
            'key' => '% comisión',
            'value' => '4',
            ],
            [
            'key' => '% descuento venta empleado',
            'value' => '50',
            ],
        ]);
    }
}
