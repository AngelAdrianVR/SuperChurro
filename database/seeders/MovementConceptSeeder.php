<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovementConceptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('movement_concepts')->insert([
            [
            'name' => 'Compra de mercancía',
            'is_entry' => true,
            ],
            [
            'name' => 'Mercancía en mal estado',
            'is_entry' => false,
            ],
            [
            'name' => 'Solicitud de mercancía',
            'is_entry' => false,
            ],
            [
            'name' => 'Venta a empleado',
            'is_entry' => false,
            ],
            
        ]);
    }
}
