<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FuelQuotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fuel_quota')->insert([
            'name' => 'Weekly Heavy Vehicle Limit',
            'weekly_quota'=>'60',
            'updated_at'=>date('Y-m-d H:i:s')
        ]);

        DB::table('fuel_quota')->insert([
            'name' => 'Weekly Light Vehicle Limit',
            'weekly_quota'=>'20',
            'updated_at'=>date('Y-m-d H:i:s')
        ]);

        DB::table('fuel_quota')->insert([
            'name' => 'Weekly Motor Bicycle Limit',
            'weekly_quota'=>'4',
            'updated_at'=>date('Y-m-d H:i:s')
        ]);
    }
}
