<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('district')->insert([
            'name' => 'Colombo',
        ]);
        DB::table('district')->insert([
            'name' => 'Gampaha'
        ]);
        DB::table('district')->insert([
            'name' => 'Kaluthara'
        ]);
    }
}
