<?php

namespace Database\Factories;

use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $hireDate = $this->faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d');
        $lastVacationDate = $this->faker->dateTimeBetween($hireDate, 'now')->format('Y-m-d');

        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'cpf' => $this->faker->unique()->numerify('###.###.###-##'),
            'rg' => $this->faker->unique()->numerify('##.###.###-#'),
            'date_of_birth' => $this->faker->date('Y-m-d', '-20 years'),
            'hire_date' => $hireDate,
            'last_vacation_date' => $lastVacationDate,
            'position_id' => Position::factory(),
            'city' => $this->faker->city,
            'employment_status' => 'active',
            'termination_date' => null,
            'termination_type' => null,
            'termination_reason' => null,
            'notice_paid' => false,
            'severance_amount' => null,
        ];
    }

    public function terminated(): Factory
    {
        return $this->state(function (array $attributes) {
            $terminationDate = $this->faker->dateTimeBetween($attributes['hire_date'], 'now')->format('Y-m-d');

            return [
                'employment_status' => 'terminated',
                'termination_date' => $terminationDate,
                'termination_type' => Arr::random(['without_cause', 'resignation', 'with_cause']),
                'termination_reason' => $this->faker->sentence(),
                'notice_paid' => $this->faker->boolean(70), // 70% chance de aviso prévio pago
                'severance_amount' => $this->faker->randomFloat(2, 1000, 50000),
            ];
        });
    }

    public function onVacation(): Factory
    {
        return $this->state(function (array $attributes) {
            $vacationStart = $this->faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d');

            return [
                'last_vacation_date' => $vacationStart,
            ];
        });
    }
}
