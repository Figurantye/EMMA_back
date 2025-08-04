<?php

namespace Database\Seeders;

use App\Models\ChecklistTasks;
use Illuminate\Database\Seeder;

class ChecklistTasksSeeder extends Seeder
{
    public function run()
    {
        $tasks = [
            [
                'title' => 'Assinar contrato',
                'description' => 'Contrato de trabalho deve ser assinado pelo funcionário',
                'order' => 1,
            ],
            [
                'title' => 'Enviar documentos pessoais',
                'description' => 'Enviar cópias de RG, CPF e comprovante de residência',
                'order' => 2,
            ],
            [
                'title' => 'Realizar treinamento inicial',
                'description' => 'Treinamento sobre segurança e normas internas',
                'order' => 3,
            ],
            [
                'title' => 'Cadastrar no sistema interno',
                'description' => 'Criar usuário e permissões no sistema EMMA',
                'order' => 4,
            ],
            [
                'title' => 'Entregar crachá de acesso',
                'description' => 'Entrega do crachá de identificação e acesso físico',
                'order' => 5,
            ],
        ];

        foreach ($tasks as $task) {
            ChecklistTasks::updateOrCreate(
                ['title' => $task['title']],
                $task
            );
        }
    }
}
