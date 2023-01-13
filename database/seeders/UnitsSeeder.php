<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('units')->insert([
            [
            'name' => 'Bolsa(s)',
            ],
            [
            'name' => 'Pieza(s)',
            ],
            [
            'name' => 'Litro(s)',
            ],
            [
            'name' => 'Cubeta(s)',
            ],
            [
            'name' => 'Plato(s)',
            ],
            [
            'name' => 'botella(s)',
            ],
            [
            'name' => 'Kilogramo(s)',
            ],
            [
            'name' => 'Vaso(s)',
            ],
        ]);
    }
}
