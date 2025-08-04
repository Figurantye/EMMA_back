<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmployeeChecklistItem;

class EmployeeChecklistItemSeeder extends Seeder
{
    public function run(): void
    {
        EmployeeChecklistItem::insert([
            [
                'employee_checklist_id' => 1,
                'checklist_template_item_id' => 1,
                'completed' => false,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_checklist_id' => 1,
                'checklist_template_item_id' => 2,
                'completed' => true,
                'notes' => 'Ambiente configurado no 2º dia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_checklist_id' => 1,
                'checklist_template_item_id' => 3,
                'completed' => false,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_checklist_id' => 2,
                'checklist_template_item_id' => 4,
                'completed' => false,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_checklist_id' => 2,
                'checklist_template_item_id' => 5,
                'completed' => false,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
