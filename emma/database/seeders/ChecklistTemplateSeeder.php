<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChecklistTemplate;

class ChecklistTemplateSeeder extends Seeder
{
    public function run(): void
    {
        ChecklistTemplate::insert([
            [
                'name' => 'Jr Dev - First Week',
                'description' => 'First week onboarding checklist for junior developers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Manager Onboarding',
                'description' => 'Checklist for new management hires',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
