<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            AppointmentSeeder::class,
            UserSeeder::class,
            AdminSeeder::class,
            SectionSeeder::class,
            DoctorSeeder::class,
            ServiceSeeder::class,
            PatientSeeder::class,
            RayEmployeeSeeder::class,
            LaboratorieEmployeeSeeder::class,
        ]);
    }
}
