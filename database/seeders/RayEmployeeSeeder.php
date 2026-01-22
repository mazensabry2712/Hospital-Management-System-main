<?php

namespace Database\Seeders;

use App\Models\RayEmployee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RayEmployeeSeeder extends Seeder
{

    public function run()
    {
        // RayEmployee::create([
        //     'name' => 'mohamed',
        //     'email' => 'mohamed@yahoo.com',
        //     'password' => Hash::make('123456789'),
        // ]);

        DB::table('ray_employees')->insert([
            'created_at' => now(),
            'name' => 'mohamed',
            'email' => 'mohamed@yahoo.com',
            'password' => Hash::make('123456789'),
        ]);
    }
}
