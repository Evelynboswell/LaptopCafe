<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('services')->insert([
            ['service_name' => 'Maintenence / Coolmax', 'service_price' => 200000, 'warranty_range' => 2],
            ['service_name' => 'Software / Virus', 'service_price' => 85000, 'warranty_range' => 1],
            ['service_name' => 'Mainboard', 'service_price' => 450000, 'warranty_range' => 2],
            ['service_name' => 'Charger', 'service_price' => 100000, 'warranty_range' => 1],
            ['service_name' => 'Keyboard', 'service_price' => 100000, 'warranty_range' => 1],
            ['service_name' => 'Casing / Engsel', 'service_price' => 200000, 'warranty_range' => 2],
            ['service_name' => 'Data Recovery', 'service_price' => 250000, 'warranty_range' => 2],
            ['service_name' => 'Motherboard Health Check', 'service_price' => 75000, 'warranty_range' => 1],
            ['service_name' => 'Laptop Health Check', 'service_price' => 25000, 'warranty_range' => 1],
        ]);
    }
}
