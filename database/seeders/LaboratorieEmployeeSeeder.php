<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LaboratorieEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('laboratorie_employees')->insert([
            'created_at' => now(),
            'name' => 'mohamed',
            'email' => 'la@yahoo.com',
            'password' => Hash::make('123456789'),
        ]);
    }
}
