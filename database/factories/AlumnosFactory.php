<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Users>
 */
class AlumnosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre'   => $this->faker->name(),
            'telefono' => $this->faker->phoneNumber(),
            'edad'     => $this->faker->numberBetween(12, 25),
            'password' => $this->faker->password(),
            'email'    => $this->faker->email(),
            'sexo'     => $this->faker->randomElement(['male', 'female']),
        ];
    }
}
