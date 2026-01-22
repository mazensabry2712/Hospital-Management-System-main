<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'address' => $this->faker->address(),
            'gender' => $this->faker->randomElement([1, 2]),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('123456789'),
            'date_birth' => $this->faker->date(),
            'phone' => $this->faker->phoneNumber(),
            'blood_group' => $this->faker->bloodGroup(),
        ];
    }
}
