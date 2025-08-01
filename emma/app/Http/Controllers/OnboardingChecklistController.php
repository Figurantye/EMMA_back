<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OnboardingChecklist;
use App\Models\Employee;
use Illuminate\Http\Request;

class OnboardingChecklistController extends Controller
{
    // Retorna o checklist e status de um funcionário
    public function show(Employee $employee)
    {
        // Pega ou cria checklist do funcionário
        $checklist = OnboardingChecklist::firstOrCreate([
            'employee_id' => $employee->id,
        ]);

        $checklist->load('statuses.task');

        return response()->json($checklist);
    }
}
