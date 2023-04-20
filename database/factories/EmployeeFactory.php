<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "given_names" => $this->faker->name(),
            "sur_name" => $this->faker->name(),
            "father_name" => "",
            "position_id" => mt_rand(1, 3)
        ];
    }
}
