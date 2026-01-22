<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Image;
use App\Models\Section;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Doctor::factory()->count(30)->create();
        $doctors = Doctor::all();
        $appointments = Appointment::pluck('id')->toArray();

        // Assign random appointments to each doctor
        foreach ($doctors as $doctor) {
            // اختيار 1 إلى 3 مواعيد عشوائية
            $randomAppointments = (array) array_rand(array_flip($appointments), rand(1, 3));

            // ربط الطبيب بالمواعيد
            $doctor->appointments()->attach($randomAppointments);
            Image::factory()->create([
                'imageable_id' => $doctor->id,
                'imageable_type' => Doctor::class,
            ]);
        }
    }
}
