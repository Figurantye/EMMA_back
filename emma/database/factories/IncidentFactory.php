<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Incident>
 */
class IncidentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_id' => Employee::inRandomOrder()->first()?->id ?? Employee::factory(),
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'date' => $this->faker->date(),
            'severity' => $this->faker->randomElement(['low', 'medium', 'high']),
        ];
    }
}
