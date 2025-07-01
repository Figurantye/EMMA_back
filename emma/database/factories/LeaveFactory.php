<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Leave>
 */
class LeaveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('-3 months', 'now');
        $end = (clone $start)->modify('+' . rand(3, 10) . ' days');

        return [
            'employee_id' => Employee::factory(),
            'type' => $this->faker->randomElement(['vacation', 'medical', 'unpaid', 'other']),
            'reason' => $this->faker->sentence,
            'start_date' => $start->format('Y-m-d'),
            'end_date' => $end->format('Y-m-d'),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
        ];
    }
}
