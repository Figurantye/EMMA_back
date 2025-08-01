<?php

namespace App\Listeners;

use App\Events\EmployeeCreated;
use App\Models\ChecklistTask;
use App\Models\OnboardingChecklist;
use App\Models\EmployeeChecklistStatus;

class CreateOnboardingChecklist
{
    public function handle(EmployeeCreated $event)
    {
        $employee = $event->employee;

        // Cria checklist para o funcionário
        $checklist = OnboardingChecklist::create([
            'employee_id' => $employee->id,
        ]);

        // Busca todas as tarefas padrão
        $tasks = ChecklistTask::all();

        // Cria status pendentes para cada tarefa
        foreach ($tasks as $task) {
            EmployeeChecklistStatus::create([
                'onboarding_checklist_id' => $checklist->id,
                'checklist_task_id' => $task->id,
                'status' => 'pending',
            ]);
        }
    }
}
