<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EmployeeChecklistStatus;
use Illuminate\Http\Request;

class EmployeeChecklistStatusController extends Controller
{
    public function update(Request $request, EmployeeChecklistStatus $employeeChecklistStatus)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
            'comments' => 'nullable|string',
            'completed_at' => 'nullable|date',
        ]);

        if ($data['status'] === 'completed' && empty($data['completed_at'])) {
            $data['completed_at'] = now();
        }

        $employeeChecklistStatus->update($data);

        return response()->json($employeeChecklistStatus);
    }
}
