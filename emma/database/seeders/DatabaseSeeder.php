<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {/*
        \App\Models\User::factory()->create([
            'name' => 'Admin RH',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);
        */

        \App\Models\Department::factory(3)->create()->each(function ($department) {
            \App\Models\Position::factory(2)->create([
                'department_id' => $department->id,
            ])->each(function ($position) {
                \App\Models\Employee::factory(5)->create([
                    'position_id' => $position->id,
                ])->each(function ($employee) {
                    \App\Models\Absence::factory(rand(0, 3))->create([
                        'employee_id' => $employee->id,
                    ]);
                    
                    \App\Models\LaborRight::factory()->create([
                        'employee_id' => $employee->id,
                    ]);
                    
                    \App\Models\Salary::factory()->create([
                        'employee_id' => $employee->id,

                    ]);

                    \App\Models\Tags::factory(rand(1, 3))->create([
                        'employee_id' => $employee->id,
                    ]);
                    
                    \App\Models\Attendance::factory(5)->create([
                        'employee_id' => $employee->id,
                    ]);
                    
                    \App\Models\Leave::factory()->create([
                        'employee_id' => $employee->id,
                    ]);
                    
                    \App\Models\Document::factory()->create([
                        'employee_id' => $employee->id,
                    ]);
                    \App\Models\Report::factory()->create([
                        'employee_id' => $employee->id,
                    ]);
                });
            });
        });
    }
}
