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
                'created_at' => now(),
                'is_employee_price' => false
            ],
            [
                'price' => 23,
                'product_id' => 2,
                'created_at' => now(),
                'is_employee_price' => false
            ],
            [
                'price' => 20,
                'product_id' => 3,
                'created_at' => now(),
                'is_employee_price' => false
            ],
            [
                'price' => 20,
                'product_id' => 4,
                'created_at' => now(),
                'is_employee_price' => false
            ],
            [
                'price' => 28,
                'product_id' => 5,
                'created_at' => now(),
                'is_employee_price' => false
            ],
            [
                'price' => 6,
                'product_id' => 6,
                'created_at' => now(),
                'is_employee_price' => false
            ],
            [
                'price' => 12,
                'product_id' => 7,
                'created_at' => now(),
                'is_employee_price' => false
            ],
            [
                'price' => 12,
                'product_id' => 8,
                'created_at' => now(),
                'is_employee_price' => false
            ],
            [
                'price' => 30,
                'product_id' => 9,
                'created_at' => now(),
                'is_employee_price' => false
            ],
            [
                'price' => 48,
                'product_id' => 10,
                'created_at' => now(),
                'is_employee_price' => false
            ],
            [
                'price' => 42,
                'product_id' => 11,
                'created_at' => now(),
                'is_employee_price' => false
            ],
            [
                'price' => 16,
                'product_id' => 12,
                'created_at' => now(),
                'is_employee_price' => false
            ],
            [
                'price' => 17,
                'product_id' => 13,
                'created_at' => now(),
                'is_employee_price' => false
            ],
            [
                'price' => 23,
                'product_id' => 14,
                'created_at' => now(),
                'is_employee_price' => false
            ],
            [
                'price' => 20,
                'product_id' => 1,
                'created_at' => now(),
                'is_employee_price' => true,
            ],
            [
                'price' => 20,
                'product_id' => 2,
                'created_at' => now(),
                'is_employee_price' => true,
            ],
            [
                'price' => 15,
                'product_id' => 3,
                'created_at' => now(),
                'is_employee_price' => true,
            ],
            [
                'price' => 15,
                'product_id' => 4,
                'created_at' => now(),
                'is_employee_price' => true,
            ],
            [
                'price' => 20,
                'product_id' => 5,
                'created_at' => now(),
                'is_employee_price' => true,
            ],
            [
                'price' => 5,
                'product_id' => 6,
                'created_at' => now(),
                'is_employee_price' => true,
            ],
            [
                'price' => 8,
                'product_id' => 7,
                'created_at' => now(),
                'is_employee_price' => true,
            ],
            [
                'price' => 8,
                'product_id' => 8,
                'created_at' => now(),
                'is_employee_price' => true,
            ],
            [
                'price' => 20,
                'product_id' => 9,
                'created_at' => now(),
                'is_employee_price' => true,
            ],
            [
                'price' => 38,
                'product_id' => 10,
                'created_at' => now(),
                'is_employee_price' => true,
            ],
            [
                'price' => 30,
                'product_id' => 11,
                'created_at' => now(),
                'is_employee_price' => true,
            ],
            [
                'price' => 13,
                'product_id' => 12,
                'created_at' => now(),
                'is_employee_price' => true,
            ],
            [
                'price' => 12,
                'product_id' => 13,
                'created_at' => now(),
                'is_employee_price' => true,
            ],
            [
                'price' => 15,
                'product_id' => 14,
                'created_at' => now(),
                'is_employee_price' => true,
            ],

        ]);
    }
}
