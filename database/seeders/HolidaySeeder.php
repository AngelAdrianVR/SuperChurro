<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('holidays')->insert([
            [
                'name' => 'Año nuevo',
                'date' => '01-01',
                'is_active' => true,
            ],
            [
                'name' => 'Día de la constitución',
                'date' => '07-02',
                'is_active' => true,
            ],
            [
                'name' => 'Natalicio de Benito Juárez',
                'date' => '21-03',
                'is_active' => true,
            ],
            [
                'name' => 'Día del trabajo',
                'date' => '01-05',
                'is_active' => true,
            ],
            [
                'name' => 'Independencia de México',
                'date' => '16-09',
                'is_active' => true,
            ],
            [
                'name' => 'Revolución mexicana',
                'date' => '21-11',
                'is_active' => true,
            ],
            [
                'name' => 'Navidad',
                'date' => '25-12',
                'is_active' => true,
            ],
        ]);
    }
}
