<?php

namespace Database\Seeders;

use App\Models\Tags;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Department;
use App\Models\Position;
use App\Models\Employee;
use App\Models\Absence;
use App\Models\LaborRight;
use App\Models\Salary;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\Document;
use App\Models\Report;
use App\Models\Incident;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        /*
        User::factory()->create([
            'name' => 'Admin RH',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);
        */

        

        // Adicione estes se estiver usando o checklist de admissão


        Department::factory(3)->create()->each(function ($department) {
            Position::factory(2)->create([
                'department_id' => $department->id,
            ])->each(function ($position) {
                Employee::factory(5)->create([
                    'position_id' => $position->id,
                ])->each(function ($employee) {
                    Absence::factory(rand(0, 3))->create([
                        'employee_id' => $employee->id,
                    ]);

                    LaborRight::factory()->create([
                        'employee_id' => $employee->id,
                    ]);

                    Salary::factory()->create([
                        'employee_id' => $employee->id,
                    ]);

                    Tags::factory(rand(1, 3))->create([
                        'employee_id' => $employee->id,
                    ]);

                    Attendance::factory(5)->create([
                        'employee_id' => $employee->id,
                    ]);

                    Leave::factory()->create([
                        'employee_id' => $employee->id,
                    ]);

                    Document::factory()->create([
                        'employee_id' => $employee->id,
                    ]);

                    Report::factory()->create([
                        'employee_id' => $employee->id,
                    ]);

                    Incident::factory(rand(1, 2))->create([
                        'employee_id' => $employee->id,
                    ]);
                });
            });
        });
        // Seed de e-mails autorizados
        $this->call([
            AuthorizedEmailsSeeder::class,
            ChecklistTemplateSeeder::class,
            ChecklistTemplateItemSeeder::class,
            EmployeeChecklistSeeder::class,
            EmployeeChecklistItemSeeder::class,
        ]);
    }
    
}
