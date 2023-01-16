<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SuberbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('suberb')->insert([
            'name' => 'Colombo 03',
            'district_id'=>1
        ]);
        DB::table('suberb')->insert([
            'name' => 'Nugegoda',
            'district_id'=>1
        ]);
        DB::table('suberb')->insert([
            'name' => 'Maharagama',
            'district_id'=>1
        ]);

        DB::table('suberb')->insert([
            'name' => 'Minuwangoda',
            'district_id'=>2
        ]);
    }
}
