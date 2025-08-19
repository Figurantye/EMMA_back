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
                'checklist_template_id' => 1,
                'status' => 'in_progress',
                'progress' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 2,
                'checklist_template_id' => 2,
                'status' => 'pending',
                'progress' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
