<?php

namespace Database\Seeders;

use App\Models\ChecklistTasks;
use App\Models\OnboardingChecklist;
use Illuminate\Database\Seeder;

class OnboardingChecklistSeeder extends Seeder
{
    public function run(): void
    {
        // Cria o checklist principal
        $checklist = OnboardingChecklist::create([
            'title' => 'Checklist Padrão de Admissão',
            'description' => 'Tarefas obrigatórias para todo novo colaborador.',
        ]);

        // Lista de tarefas padrão
        $tasks = [
            'Preenchimento de ficha cadastral',
            'Entrega de documentos pessoais',
            'Assinatura do contrato de trabalho',
            'Cadastro no sistema de ponto',
            'Treinamento de integração',
            'Entrega de equipamentos (se necessário)',
        ];

        foreach ($tasks as $index => $taskName) {
            ChecklistTasks::create([
                'onboarding_checklist_id' => $checklist->id,
                'name' => $taskName,
                'order' => $index + 1,
            ]);
        }
    }
}
