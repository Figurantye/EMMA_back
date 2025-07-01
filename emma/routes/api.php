<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    EmployeeController,
    DepartmentController,
    SalaryController,
    AbsenceController,
    TagController,
    LaborRightController,
    AttendanceController,
    PositionController,
    DocumentController,
    LeaveController,
    ReportController
};
use App\Models\Salary;

// Rotas protegidas por autenticação (opcional, ex: Sanctum)
// Route::middleware('auth:sanctum')->group(function () {
    
// Departamentos
Route::apiResource('departments', DepartmentController::class);

// Cargo
Route::apiResource('positions', PositionController::class);

// Funcionários
Route::apiResource('employees', EmployeeController::class);

// Salários
Route::get('employees/{employee}/salaries', [SalaryController::class, 'show']);
Route::post('employees/{employee}/salaries', [SalaryController::class, 'store']);
Route::put('salaries/{salary}', [SalaryController::class, 'update']);
Route::delete('salaries/{salary}', [SalaryController::class, 'destroy']);

// Faltas
Route::get('employees/{employee}/absences', [AbsenceController::class, 'show']);
Route::post('employees/{employee}/absences', [AbsenceController::class, 'store']);
Route::put('absences/{absence}', [AbsenceController::class, 'update']);
Route::delete('absences/{absence}', [AbsenceController::class, 'destroy']);

// Presença (Attendance)
Route::get('employees/{employee}/attendances', [AttendanceController::class, 'show']);
Route::post('employees/{employee}/attendances', [AttendanceController::class, 'store']);
Route::put('attendances/{attendance}', [AttendanceController::class, 'update']);
Route::delete('attendances/{attendance}', [AttendanceController::class, 'destroy']);

// Direitos trabalhistas (Labor Rights)
Route::get('employees/{employee}/labor-rights', [LaborRightController::class, 'index']);
Route::post('employees/{employee}/labor-rights', [LaborRightController::class, 'store']);
Route::put('labor-rights/{labor_right}', [LaborRightController::class, 'update']);
Route::delete('labor-rights/{labor_right}', [LaborRightController::class, 'destroy']);

// Tags
Route::get('employees/{employee}/tags', [TagController::class, 'show']);
Route::post('employees/{employee}/tags', [TagController::class, 'store']);
Route::put('tags/{tag}', [TagController::class, 'update']);
Route::delete('tags/{tag}', [TagController::class, 'destroy']);


// Documents
Route::get('employees/{employee}/documents', [DocumentController::class, 'show']);
Route::post('employees/{employee}/documents', [DocumentController::class, 'store']);
Route::put('documents/{document}', [DocumentController::class, 'update']);
Route::delete('documents/{document}', [DocumentController::class, 'destroy']);

// Férias
Route::get('employees/{employee}/leaves', [LeaveController::class, 'show']);
Route::post('employees/{employee}/leaves', [LeaveController::class, 'store']);
Route::put('leaves/{leaves}', [LeaveController::class, 'update']);
Route::delete('leaves/{leaves}', [LeaveController::class, 'destroy']);

// Relatórios
Route::get('employees/{employee}/reports', [ReportController::class, 'show']);
Route::post('employees/{employee}/reports', [ReportController::class, 'store']);
Route::put('reports/{report}', [ReportController::class, 'update']);
Route::delete('reports/{report}', [ReportController::class, 'destroy']);
// });