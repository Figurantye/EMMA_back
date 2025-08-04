<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChecklistTemplateItem;

class ChecklistTemplateItemSeeder extends Seeder
{
    public function run(): void
    {
        ChecklistTemplateItem::insert([
            [
                'checklist_template_id' => 1,
                'title' => 'Understand company processes',
                'description' => null,
                'order' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'checklist_template_id' => 1,
                'title' => 'Configure development environment',
                'description' => null,
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'checklist_template_id' => 1,
                'title' => 'First PR review',
                'description' => null,
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'checklist_template_id' => 2,
                'title' => 'Meet with department heads',
                'description' => null,
                'order' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'checklist_template_id' => 2,
                'title' => 'Review team structure',
                'description' => null,
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}

