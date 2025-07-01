<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
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
            'name' => $this->faker->word . '.pdf',
            'type' => $this->faker->randomElement(['rg', 'cpf', 'contract']),
            'path' => 'documents/' . $this->faker->uuid . '.pdf',
        ];
    }
}
