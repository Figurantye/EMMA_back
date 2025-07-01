<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LaborRight>
 */
class LaborRightFactory extends Factory
{
    public function definition(): array
    {
        return [
            'contract_type' => $this->faker->randomElement(['CLT', 'PJ', 'Estágio', 'Temporário']),
            'workload' => $this->faker->randomElement(['40h', '30h', '20h', '12x36']),
            'is_unionized' => $this->faker->boolean(),
            'has_fgts' => $this->faker->boolean(90), // 90% chance de ser true
            'has_inss' => $this->faker->boolean(90),
            'has_13th' => $this->faker->boolean(90),
            'has_vacation' => $this->faker->boolean(90),
            'transport' => $this->faker->boolean(50),
            'meal_voucher' => $this->faker->boolean(50),
            'food_voucher' => $this->faker->boolean(50),
            'employee_id' => Employee::factory(), // ou passe diretamente no seeder
        ];
    }
}