<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Absence>
 */
class AbsenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_id' => Employee::factory(),
            'date' => $this->faker->dateTimeBetween('-2 months', 'now')->format('Y-m-d'),
            'reason' => $this->faker->randomElement(['unjustified', 'medical', 'personal']),
            'observation' => $this->faker->optional()->sentence,
        ];
    }
}
