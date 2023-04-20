<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!DB::table("positions")->count())
        {
            DB::table('positions')->insert([
                'name' => 'Bugalter',
                'created_at' => date('Y-m-d H:i:s')
            ]);
            DB::table('positions')->insert([
                'name' => 'Kassr',
                'created_at' => date('Y-m-d H:i:s')
            ]);
            DB::table('positions')->insert([
                'name' => 'Manager',
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
