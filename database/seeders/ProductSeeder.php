<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
            'name' => 'Churro Relleno',
            'low_stock' => '7',
            'unit_id' => '1',
            ],
            [
            'name' => 'Churro Natural',
            'low_stock' => '7',
            'unit_id' => '1',
            ],
            [
            'name' => 'Botana',
            'low_stock' => '7',
            'unit_id' => '2',
            ],
            [
            'name' => 'Bolis',
            'low_stock' => '7',
            'unit_id' => '2',
            ],
            [
            'name' => 'Choco Churro',
            'low_stock' => '7',
            'unit_id' => '5',
            ],
            [
            'name' => 'Lechuguilla',
            'low_stock' => '7',
            'unit_id' => '2',
            ],
            [
            'name' => 'Agua',
            'low_stock' => '7',
            'unit_id' => '6',
            ],
            [
            'name' => 'Refresco',
            'low_stock' => '7',
            'unit_id' => '6',
            ],
            [
            'name' => 'Platos',
            'low_stock' => '7',
            'unit_id' => '5',
            ],
            [
            'name' => 'Tostilocos',
            'low_stock' => '7',
            'unit_id' => '2',
            ],
            [
            'name' => 'Churro Nieve',
            'low_stock' => '7',
            'unit_id' => '8',
            ],
            [
            'name' => 'Hershey\'s',
            'low_stock' => '7',
            'unit_id' => '2',
            ],
            [
            'name' => 'Cocas',
            'low_stock' => '7',
            'unit_id' => '6',
            ],
            [
            'name' => 'Papas',
            'low_stock' => '7',
            'unit_id' => '2',
            ],
           
        ]);
    }
}
