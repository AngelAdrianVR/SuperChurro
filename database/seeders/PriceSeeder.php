<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('prices')->insert([
            [
            'price' => 25,
            'product_id' => 1,
            ],
            [
            'price' => 23,
            'product_id' => 2,
            ],
            [
            'price' => 20,
            'product_id' => 3,
            ],
            [
            'price' => 20,
            'product_id' => 4,
            ],
            [
            'price' => 28,
            'product_id' => 5,
            ],
            [
            'price' => 6,
            'product_id' => 6,
            ],
            [
            'price' => 12,
            'product_id' => 7,
            ],
            [
            'price' => 12,
            'product_id' => 8,
            ],
            [
            'price' => 30,
            'product_id' => 9,
            ],
            [
            'price' => 48,
            'product_id' => 10,
            ],
            [
            'price' => 42,
            'product_id' => 11,
            ],
            [
            'price' => 16,
            'product_id' => 12,
            ],
            [
            'price' => 17,
            'product_id' => 13,
            ],
            [
            'price' => 23,
            'product_id' => 14,
            ],
          
        ]);
    }
}
