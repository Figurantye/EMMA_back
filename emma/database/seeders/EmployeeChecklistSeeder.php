<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmployeeChecklist;

class EmployeeChecklistSeeder extends Seeder
{
    public function run(): void
    {
        EmployeeChecklist::insert([
            [
                'employee_id' => 1,
                'template_id' => 1,
                'status' => 'in_progress',
                'progress' => 33,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 2,
                'template_id' => 2,
                'status' => 'not_started',
                'progress' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
