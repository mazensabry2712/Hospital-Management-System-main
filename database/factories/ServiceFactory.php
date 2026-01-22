<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
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
            'status' => 1,
            'price' => $this->faker->numberBetween(500,100),
            'description' => $this->faker->paragraph
        ];
    }
}
