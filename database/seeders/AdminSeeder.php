<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Schema::hasTable('admins')){
            if (Admin::count() == 0){
                Admin::create([
                    'given_names'     => 'Admin',
                    'sur_name'        => "Admin",
                    'login'           => "admin",
                    'password'        => Hash::make('admin'),
                ]);
            }
        }
    }
}
