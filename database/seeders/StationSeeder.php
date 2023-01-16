<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fuel_station')->insert([
            'name' => 'Duplication Road Fuel Station',
            'district_id'=>1,
            'suberb_id'=>1,
            'max_volume'=>10000,
            'min_volume'=>500,
            'available_volume'=>8000,
            'secret_code'=>md5('12345')
        ]);
        DB::table('fuel_station')->insert([
            'name' => 'Maharagama Laugf Fuel Station',
            'district_id'=>1,
            'suberb_id'=>3,
            'max_volume'=>10000,
            'min_volume'=>500,
            'available_volume'=>9000,
            'secret_code'=>md5('123456')
        ]);
    }
}
